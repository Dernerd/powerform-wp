<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Front action for quizzes
 *
 * @since 1.0
 */
class Powerform_Quizz_Front_Action extends Powerform_Front_Action {

	/**
	 * Entry type
	 *
	 * @since 1.0
	 * @var string
	 */
	public $entry_type = 'quizzes';

	/**
	 * Entry type
	 *
	 * @since 1.0
	 * @var string
	 */
	public $model = null;

	/**
	 * Handle quiz submit
	 *
	 * @since 1.0
	 * @since 1.1 refactor $_POST to get_post_data to be able pre-processed
	 * @since 1.6.2 add $is_preview as arg
	 *
	 * @param bool $is_preview
	 */
	public function submit_quizzes( $is_preview = false ) {
		$post_data = $this->get_post_data(
			array(
				'powerform_submit_form',
				'powerform_nonce',
			)
		);

		$id = isset( $post_data['form_id'] ) ? $post_data['form_id'] : null;

		/** @var  Powerform_Quiz_Form_Model $model */
		$this->model = Powerform_Quiz_Form_Model::model()->load( $id );

		if ( ! is_object( $this->model ) ) {
			wp_send_json_error(
				array(
					'error' => apply_filters( 'powerform_submit_quiz_error_not_found', __( "Formular nicht gefunden", Powerform::DOMAIN ) ),
				)
			);
		}

		/**
		 * Action called before submit quizzes
		 *
		 * @param Powerform_Quiz_Form_Model $model - the quiz model
		 * @param bool                       $is_preview
		 */
		do_action( 'powerform_before_submit_quizzes', $this->model, $is_preview );

		if ( 'nowrong' === $this->model->quiz_type ) {
			$this->_process_nowrong_submit( $this->model, $is_preview );
		} else {
			$this->_process_knowledge_submit( $this->model, $is_preview );
		}
	}

	/**
	 * Process No wrong quiz
	 *
	 * @since 1.0
	 * @since 1.6.2 add $is_preview as arg
	 *
	 * @param Powerform_Quiz_Form_Model $model
	 * @param bool                       $is_preview
	 */
	private function _process_nowrong_submit( $model, $is_preview = false ) {
		// disable submissions if not published
		if ( Powerform_Quiz_Form_Model::STATUS_PUBLISH !== $model->status ) {
			wp_send_json_error(
				array(
					'error' => __( "Quizübermittlungen deaktiviert.", Powerform::DOMAIN ),
				)
			);
		}

		//counting the result
		$results     = array();
		$result_data = array();
		$post_data   = $this->get_post_data();

		if ( isset( $post_data['answers'] ) ) {
			foreach ( $post_data['answers'] as $id => $answer ) {
				// collecting the results from answer
				$results[]                = $model->getResultFromAnswer( $id, $answer );
				$question                 = $model->getQuestion( $id );
				$a                        = $model->getAnswer( $id, $answer );
				$result_data['answers'][] = array(
					'question' => $question['title'],
					'answer'   => $a['title'],
				);
			}
		}

		/**
		 * collecting the results from answer with count as values
		 * {
		 *      'result-id-1' => `COUNT`,
		 *      'result-id-2' => `COUNT`,
		 * }
		 */
		$answer_results = array_count_values( $results );
		$final_res      = $model->get_nowrong_result( $answer_results );

		$result_data['result'] = $final_res;

		//ADDON on_form_submit
		$addon_error = $this->attach_addons_on_quiz_submit( $model->id, $model );
		if ( true !== $addon_error ) {
			wp_send_json_error(
				array(
					'error' => $addon_error,
				)
			);
		}

		$entry = $this->_save_entry(
			$model,
			// why on earth it saved like this
			array(
				array(
					'name'  => 'entry',
					'value' => $result_data,
				),
			),
			$is_preview,
            $post_data
		);
		$entries  = new Powerform_Form_Entry_Model( $entry->entry_id );
		$entry_id = $entry->entry_id;

		$result = new Powerform_QForm_Result();
		$result->set_entry( $entry_id );
		$result->set_postdata( $post_data );

		// Email
		$powerform_mail_sender = new Powerform_Quiz_Front_Mail();
		$powerform_mail_sender->process_mail( $model, $post_data, $entries );

		// dont push history on preview
		$result_url = ! $is_preview ? $result->build_permalink() : '';

		//replace tags if any
		foreach ( array( 'title', 'description' ) as $key ) {
			if ( isset( $final_res[ $key ] ) ) {
				if ( 'description' === $key ) {
					$final_res[ $key ] = do_shortcode( $final_res[ $key ] );
				}
				$final_res[ $key ] = powerform_replace_quiz_form_data( $final_res[ $key ], $model, $post_data, $entry );
			}
		}

		wp_send_json_success(
			array(
				'result'     => $this->_render_nowrong_result( $model, $final_res, $post_data, $entry ),
				'result_url' => $result_url,
				'type'       => 'nowrong',
			)
		);
	}

	/**
	 * Render No wrong result
	 *
	 * @since 1.0
	 *
	 * @param Powerform_Quiz_Form_Model      $model
	 * @param    array                        $result
	 * @param    array                        $data
	 * @param    Powerform_Form_Entry_Model  $entry
	 *
	 * @return string
	 */
	private function _render_nowrong_result( $model, $result, $data, Powerform_Form_Entry_Model $entry ) {
		ob_start();
		$description = '';

		if ( ! is_array( $data ) ) {
			$data = array();
		}

		$theme       = isset( $model->settings['powerform-quiz-theme'] ) ? $model->settings['powerform-quiz-theme'] : '';

		if ( ! $theme ) {
			$theme = 'default';
		}
		//replace tags if any
        if ( isset( $result['description'] ) && ! empty( $result['description'] ) ) {
            $description = powerform_replace_quiz_form_data( $result['description'], $model, $data, $entry );
        }
		?>

		<?php if ( 'clean' === $theme ) { ?>

			<div class="powerform-result" role="group">

				<p><strong><?php echo esc_html( $result['title'] ); ?></strong></p>

				<?php if ( ! empty( $description ) ) : ?>
					<p><?php echo $description; // wpcs xss ok. ?></p>
				<?php endif; ?>

				<?php if ( isset( $result['image'] ) && ! empty( $result['image'] ) ) : ?>
					<img src="<?php echo esc_html( $result['image'] ); ?>" aria-hidden="true" class="powerform-result--image" />
				<?php endif; ?>

				<button class="powerform-result--retake" type="button">
					<span class="powerform-icon-refresh" aria-hidden="true"></span>
					<span><?php esc_html_e( "Wiederhole Quiz", Powerform::DOMAIN ); ?></span>
				</button>

			</div>

		<?php } else { ?>

			<div class="powerform-result" role="group">

				<?php if ( 'material' === $theme ) { ?>

					<?php if ( isset( $result['image'] ) && ! empty( $result['image'] ) ) { ?>
						<img src="<?php echo esc_html( $result['image'] ); ?>" class="powerform-result--image" aria-hidden="true" />
					<?php } ?>

					<div class="powerform-result--content">

						<p class="powerform-result--title"><?php echo esc_html( $result['title'] ); ?></p>

						<?php if ( ! empty( $description ) ) : ?>
							<div class="powerform-result--description"><?php echo $description; // wpcs xss ok. ?></div>
						<?php endif; ?>

						<hr />

						<button class="powerform-result--retake" type="button"><?php esc_html_e( 'Wiederhole Quiz', Powerform::DOMAIN ); ?></button>

					</div>

				<?php } else { ?>

					<div class="powerform-result--info">

						<span class="powerform-result--quiz-name"><?php echo powerform_get_quiz_name( $model->id ); // WPCS: XSS ok. ?></span>

						<button class="powerform-result--retake" type="button">
							<span class="powerform-icon-refresh" aria-hidden="true"></span>
							<span><?php esc_html_e( "Wiederhole Quiz", Powerform::DOMAIN ); ?></span>
						</button>

					</div>

					<div class="powerform-result--content">

						<div class="powerform-result--text">

							<p class="powerform-result--title"><?php echo esc_html( $result['title'] ); ?></p>

							<?php if ( ! empty( $description ) ): ?>
								<div class="powerform-result--description"><?php echo $description; // wpcs xss ok. ?></div>
							<?php endif; ?>

						</div>

						<?php if ( isset( $result['image'] ) && ! empty( $result['image'] ) ) { ?>
							<div class="powerform-result--image" style="background-image: url('<?php echo esc_html( $result['image'] ); ?>');" aria-hidden="true">
								<img src="<?php echo esc_html( $result['image'] ); ?>" />
							</div>
						<?php } ?>

					</div>

				<?php } ?>

			</div>

		<?php } ?>

		<?php
		$is_enabled = isset( $model->settings['enable-share'] ) && "on" === $model->settings['enable-share'];
		$is_fb = isset( $model->settings['facebook'] ) && filter_var( $model->settings['facebook'], FILTER_VALIDATE_BOOLEAN );
		$is_tw = isset( $model->settings['twitter'] ) && filter_var( $model->settings['twitter'], FILTER_VALIDATE_BOOLEAN );
		$is_li = isset( $model->settings['linkedin'] ) && filter_var( $model->settings['linkedin'], FILTER_VALIDATE_BOOLEAN );

		if ( $is_enabled ) {
			if ( $is_fb || $is_tw || $is_li ):
                $result_message = powerform_get_social_message( $model->settings, $model->settings['formName'], $result['title'], $data );
				?>
				<div class="powerform-quiz--social">
					<p class="powerform-social--text"><?php esc_html_e( "Share your results", Powerform::DOMAIN ); ?></p>
					<ul class="powerform-social--icons"
						data-message="<?php echo esc_html( $result_message ); ?>"
                        data-url="<?php echo isset( $data['current_url'] ) ? esc_url( $data['current_url'] ) : powerform_get_current_url(); ?>">
						<?php if ( $is_fb ): ?>
							<li class="powerform-social--icon">
								<a href="#" data-social="facebook" aria-label="<?php esc_html_e( 'Auf Facebook teilen', Powerform::DOMAIN ); ?>">
									<i class="powerform-icon-social-facebook" aria-hidden="true"></i>
									<span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf Facebook teilen', Powerform::DOMAIN ); ?></span>
								</a>
							</li>
						<?php endif; ?>
						<?php if ( $is_tw ): ?>
							<li class="powerform-social--icon">
								<a href="#" data-social="twitter" aria-label="<?php esc_html_e( 'Auf Twitter teilen', Powerform::DOMAIN ); ?>">
									<i class="powerform-icon-social-twitter" aria-hidden="true"></i>
									<span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf Twitter teilen', Powerform::DOMAIN ); ?></span>
								</a>
							</li>
						<?php endif; ?>
						<?php if ( $is_li ): ?>
							<li class="powerform-social--icon">
								<a href="#" data-social="linkedin" aria-label="<?php esc_html_e( 'Auf LinkedIn teilen', Powerform::DOMAIN ); ?>">
									<i class="powerform-icon-social-linkedin" aria-hidden="true"></i>
									<span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf LinkedIn teilen', Powerform::DOMAIN ); ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php } ?>

		<?php

		$nowrong_result_html = ob_get_clean();

		/**
		 * Filter to modify nowrong results
		 *
		 * @since 1.0.2
		 * @since 1.6.2 change $final_res to $result with property
		 *
		 * @param string                     $nowrong_result_html - the return html
		 * @param Powerform_Quiz_Form_Model $model               - the model
		 * @param string                     $result              - the final result
		 *
		 * @return string $nowrong_result_html
		 */
		return apply_filters( 'powerform_quizzes_render_nowrong_result', $nowrong_result_html, $model, $result );
	}

	/**
	 * Update payment amount
	 *
	 * @since 1.7.3
	 */
	public function update_payment_amount() {
		// Update payment amount
	}

	/**
	 * Process knowledge quiz
	 *
	 * @since 1.0
	 * @since 1.1 refactor $_POST to use `get_post_data()` to be able pre-processed
	 * @since 1.6.2 add $is_preview on arg
	 *
	 * @param      $model
	 * @param bool $is_preview
	 */
	private function _process_knowledge_submit( $model, $is_preview = false ) {
		// disable submissions if not published
		if ( Powerform_Quiz_Form_Model::STATUS_PUBLISH !== $model->status ) {
			wp_send_json_error(
				array(
					'error' => __( "Quizübermittlungen deaktiviert.", Powerform::DOMAIN ),
				)
			);
		}

		$post_data = $this->get_post_data();
		$answers   = isset( $post_data['answers'] ) ? $post_data['answers'] : null;
		if ( ! is_array( $answers ) || 0 === count( $answers ) ) {
			wp_send_json_error(
				array(
					'error' => apply_filters( 'powerform_quizzes_process_knowledge_submit_no_answer_error', __( "Du hast keine Fragen beantwortet", Powerform::DOMAIN ) ),
				)
			);
		}
		$results   = array();
		$is_finish = true;
		/** @var Powerform_Quiz_Form_Model $model */
		if ( count( $model->questions ) !== count( $answers ) ) {
			if ( 'end' === $model->settings['results_behav'] ) {
				//need to check if all the questions are answered
				wp_send_json_error(
					array(
						'error' => apply_filters( 'powerform_quizzes_process_knowledge_submit_answer_all_error', __( "Bitte beantworte alle Fragen", Powerform::DOMAIN ) ),
					)
				);
			} else {
				$is_finish = false;
			}
		}
		//todo need to have a filter for answers if we use the result when chose
		$right_counter = 0;
		$result_data   = array();
		$final_text    = isset( $model->settings['msg_count'] ) ? $model->settings['msg_count'] : '';
		foreach ( $answers as $id => $pick ) {
			$question = $model->getQuestion( $id );
			$meta     = array(
				'question' => $question['title'],
			);

			$correct_answers = $model->get_correct_answers_for_question( $id );

			$is_correct  = $model->is_correct_answer_for_question( $id, $pick );
			$user_answer = $model->getAnswer( $id, $pick );

			$correct_text   = isset( $model->settings['msg_correct'] ) ? $model->settings['msg_correct'] : '';
			$incorrect_text = isset( $model->settings['msg_incorrect'] ) ? $model->settings['msg_incorrect'] : '';

			if ( $is_correct ) {
				if ( isset( $user_answer['title'] ) ) {
					$correct_text = str_replace(
						'%UserAnswer%',
						$user_answer['title'],
						$correct_text
					);
				}

				// make sure correct answer exists before pluck it
				if ( ! empty( $correct_answers ) && is_array( $correct_answers ) ) {
					$correct_text = str_replace(
						'%CorrectAnswer%',
						implode( ', ', wp_list_pluck( $correct_answers, 'title' ) ),
						$correct_text
					);
				}


				$results[ $id ]['message']   = $correct_text;
				$results[ $id ]['isCorrect'] = true;
				$results[ $id ]['answer']    = $id . '-' . $pick;

				$meta['answer']    = $user_answer['title'];
				$meta['isCorrect'] = true;

				$right_counter ++;

			} else {
				if ( isset( $user_answer['title'] ) ) {
					$incorrect_text = str_replace(
						'%UserAnswer%',
						$user_answer['title'],
						$incorrect_text
					);
				}

				// make sure correct answer exists before pluck it
				if ( ! empty( $correct_answers ) && is_array( $correct_answers ) ) {
					$incorrect_text = str_replace(
						'%CorrectAnswer%',
						implode( ', ', wp_list_pluck( $correct_answers, 'title' ) ),
						$incorrect_text
					);
				}

				$results[ $id ]['message']   = $incorrect_text;
				$results[ $id ]['isCorrect'] = false;
				$results[ $id ]['answer']    = $id . '-' . $pick;

				$meta['answer']    = $user_answer['title'];
				$meta['isCorrect'] = false;
			}
			$result_data[] = $meta;
		}

		//ADDON on_form_submit
		$addon_error = $this->attach_addons_on_quiz_submit( $model->id, $model );
		if ( true !== $addon_error ) {
			wp_send_json_error(
				array(
					'error' => $addon_error,
				)
			);
		}

		$entry    = null;
		$entries  = null;
		$entry_id = 0;

		if ( $is_finish ) {
			$entry    = $this->_save_entry( $model, $result_data, $is_preview, $post_data );
			$entries  = new Powerform_Form_Entry_Model( $entry->entry_id );
			$entry_id = $entry->entry_id;
		}

		$result = new Powerform_QForm_Result();
		$result->set_entry( $entry_id );
		$result->set_postdata( $post_data );

		$post_data['final_result'] = $right_counter;

		if ( $is_finish && ! is_null( $entry ) ) {
			// Email
			$powerform_mail_sender = new Powerform_Quiz_Front_Mail();
			$powerform_mail_sender->process_mail( $model, $post_data, $entries );
			// replace quiz form data
			$final_text = powerform_replace_quiz_form_data( $final_text, $model, $post_data, $entry );
		}

		// dont push history on preview
		$result_url = ! $is_preview ? $result->build_permalink() : '';
		//store the
		wp_send_json_success(
			array(
				'result'     => $results,
				'type'       => 'knowledge',
				'entry'      => $entry_id,
				'result_url' => $result_url,
				'finalText'  => $is_finish ? $this->_render_knowledge_result(
					str_replace(
						'%YourNum%',
						$right_counter,
						str_replace( '%Total%', count( $results ), $final_text )
					),
					$model,
					$right_counter,
					count( $results ),
					$post_data
				) : '',
			)
		);
	}

	/**
	 * Render knowledge result
	 *
	 * @since 1.0
	 *
	 * @param $text
	 * @param $model
	 * @param $data
	 *
	 * @return string
	 */
	private function _render_knowledge_result( $text, $model, $right_answers, $total_answers, $data = array() ) {
		ob_start();
		?>

		<div role="alert" class="powerform-quiz--summary"><?php echo wpautop( $text, true ); // WPCS: XSS ok. ?></div>

		<?php
		$is_enabled = true;
		$is_fb = isset( $model->settings['facebook'] ) && filter_var( $model->settings['facebook'], FILTER_VALIDATE_BOOLEAN );
		$is_tw = isset( $model->settings['twitter'] ) && filter_var( $model->settings['twitter'], FILTER_VALIDATE_BOOLEAN );
		$is_li = isset( $model->settings['linkedin'] ) && filter_var( $model->settings['linkedin'], FILTER_VALIDATE_BOOLEAN );

		if ( isset( $model->settings['enable-share'] ) && "off" === $model->settings['enable-share'] ) {
			$is_enabled = false;
		}

		if ( true === $is_enabled ) {

			if ( $is_fb || $is_tw || $is_li ) :

                $result = $right_answers . '/' . $total_answers;
                $result_message = powerform_get_social_message( $model->settings, $model->settings['formName'], $result, $data );
				?>
                <div class="powerform-quiz--social">
                    <p class="powerform-social--text"><?php esc_html_e( "Teile Deine Ergebnisse", Powerform::DOMAIN ); ?></p>
                    <ul class="powerform-social--icons"
                        data-message="<?php echo esc_textarea( $result_message ); ?>"
                        data-url="<?php echo isset( $data['current_url'] ) ? esc_url( $data['current_url'] ) : powerform_get_current_url(); ?>">
                        <?php if ( $is_fb ): ?>
                            <li class="powerform-social--icon">
                                <a href="#" data-social="facebook" aria-label="<?php esc_html_e( 'Auf Facebook teilen', Powerform::DOMAIN ); ?>">
                                    <i class="powerform-icon-social-facebook" aria-hidden="true"></i>
                                    <span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf Facebook teilen', Powerform::DOMAIN ); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( $is_tw ): ?>
                            <li class="powerform-social--icon">
                                <a href="#" data-social="twitter" aria-label="<?php esc_html_e( 'Auf Twitter teilen', Powerform::DOMAIN ); ?>">
                                    <i class="powerform-icon-social-twitter" aria-hidden="true"></i>
                                    <span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf Twitter teilen', Powerform::DOMAIN ); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( $is_li ): ?>
                            <li class="powerform-social--icon">
                                <a href="#" data-social="linkedin" aria-label="<?php esc_html_e( 'Auf LinkedIn teilen', Powerform::DOMAIN ); ?>">
                                    <i class="powerform-icon-social-linkedin" aria-hidden="true"></i>
                                    <span class="powerform-screen-reader-only"><?php esc_html_e( 'Auf LinkedIn teilen', Powerform::DOMAIN ); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
			<?php endif; ?>

		<?php } ?>

		<?php
		$knowledge_result_html = ob_get_clean();
		$knowledge_result_html = do_shortcode( $knowledge_result_html );

		/**
		 * Filter to modify knowledge results
		 *
		 * @since 1.0.2
		 *
		 * @param string                     $knowledge_result_html - the return html
		 * @param string                     $text                  - the summary text
		 * @param Powerform_Quiz_Form_Model $model                 - the model
		 *
		 * @return string $knowledge_result_html
		 */
		return apply_filters( 'powerform_quizzes_render_knowledge_result', $knowledge_result_html, $text, $model );
	}

	/**
	 * Save entry
	 *
	 * @since 1.0
	 * @return void /json Json response
	 */
	public function save_entry() {
		$this->submit_quizzes();
	}

	/**
	 * Save entry
	 *
	 * @since 1.6
	 * @return void
	 */
	public function save_entry_preview() {
		$this->submit_quizzes( true );
	}

	/**
	 * @since 1.0
	 * @since 1.2 return entry id on success, or false on fail
	 * @since 1.6.2 change 1st arg from form_id to quiz model
	 *        - Add $is_preview as func arg
	 *
	 * @param Powerform_Quiz_Form_Model $quiz
	 * @param                            $field_data
	 * @param bool                       $is_preview
	 * @param array                      $data
	 *
	 * @return Powerform_Form_Entry_Model
	 */
	private function _save_entry( $quiz, $field_data, $is_preview = false, $data = array() ) {
		$quiz_id           = $quiz->id;
		$entry             = new Powerform_Form_Entry_Model();
		$entry->entry_type = $this->entry_type;
		$entry->form_id    = $quiz_id;

		$data_entry = isset( $data['entry_id'] ) ? $data['entry_id'] : null;
		$skip_form  = false;

        if ( $this->has_skip_form() && empty( $data_entry ) ) {
	        $skip_form = true;
        }

		$is_prevent_store = $quiz->is_prevent_store();
		if ( $is_preview || $is_prevent_store || $entry->save( null, $data_entry ) ) {
			$current_url = powerform_get_current_url();

			if ( ! empty( $data['current_url'] ) ) {
				$current_url = $data['current_url'];
			}
			$field_data_array = array(
				array(
					'name'  => 'entry',
					'value' => $field_data,
				),
				array(
					'name'  => 'quiz_url',
					'value' => $current_url,
				),
                array(
					'name'  => 'skip_form',
					'value' => $skip_form,
				),
			);

			// ADDON add_entry_fields
			$added_data_array = $this->attach_addons_add_entry_fields( $quiz_id, $quiz, $field_data_array );
			$added_data_array = array_merge( $field_data_array, $added_data_array );

			/**
			 * Action called before setting fields to database
			 *
			 * @since 1.0.2
			 *
			 * @param Powerform_Form_Entry_Model $entry      - the entry model
			 * @param int                         $quiz_id    - the quiz id
			 * @param array                       $field_data - the entry data
			 *
			 */
			do_action( 'powerform_quizzes_submit_before_set_fields', $entry, $quiz_id, $field_data );
			$entry->set_fields( $added_data_array );

			//ADDON after_entry_saved
			$this->attach_addons_after_entry_saved( $quiz_id, $entry );
		}

		return $entry;
	}

	public function handle_submit() {
	}

	/**
	 * Executor On quiz submit for attached addons
	 *
	 * @see   Powerform_Addon_Quiz_Hooks_Abstract::on_quiz_submit()
	 * @since 1.6.2
	 *
	 * @param                              $quiz_id
	 * @param Powerform_Quiz_Form_Model   $quiz_model
	 *
	 * @return bool true on success|string error message from addon otherwise
	 */
	private function attach_addons_on_quiz_submit( $quiz_id, Powerform_Quiz_Form_Model $quiz_model ) {
		$submitted_data = powerform_addon_format_quiz_submitted_data( $_POST, $_FILES );// WPCS: CSRF ok. its already validated before.
		//find is_form_connected
		$connected_addons = powerform_get_addons_instance_connected_with_quiz( $quiz_id );

		foreach ( $connected_addons as $connected_addon ) {
			try {
				$quiz_hooks = $connected_addon->get_addon_quiz_hooks( $quiz_id );
				if ( $quiz_hooks instanceof Powerform_Addon_Quiz_Hooks_Abstract ) {
					$addon_return = $quiz_hooks->on_quiz_submit( $submitted_data );
					if ( true !== $addon_return ) {
						return $quiz_hooks->get_submit_quiz_error_message();
					}
				}
			} catch ( Exception $e ) {
				powerform_addon_maybe_log( $connected_addon->get_slug(), 'failed to attach_addons_on_quiz_submit', $e->getMessage() );
			}

		}

		return true;
	}

	/**
	 * Executor to add more entry fields for attached addons
	 *
	 * @see   Powerform_Addon_Quiz_Hooks_Abstract::add_entry_fields()
	 *
	 * @since 1.6.2
	 *
	 * @param                              $quiz_id
	 * @param Powerform_Quiz_Form_Model   $quiz_form_model
	 * @param array                        $current_entry_fields
	 *
	 * @return array added fields to entry
	 */
	private function attach_addons_add_entry_fields( $quiz_id, Powerform_Quiz_Form_Model $quiz_form_model, $current_entry_fields ) {
		$additional_fields_data = array();
		$submitted_data         = powerform_addon_format_quiz_submitted_data( $_POST, $_FILES );// WPCS: CSRF ok. its already validated before.
		//find is_quiz_connected
		$connected_addons = powerform_get_addons_instance_connected_with_quiz( $quiz_id );

		foreach ( $connected_addons as $connected_addon ) {
			try {
				$quiz_hooks = $connected_addon->get_addon_quiz_hooks( $quiz_id );
				if ( $quiz_hooks instanceof Powerform_Addon_Quiz_Hooks_Abstract ) {
					$addon_fields = $quiz_hooks->add_entry_fields( $submitted_data, $current_entry_fields );
					//reformat additional fields
					$addon_fields           = self::format_addon_additional_fields( $connected_addon, $addon_fields );
					$additional_fields_data = array_merge( $additional_fields_data, $addon_fields );
				}
			} catch ( Exception $e ) {
				powerform_addon_maybe_log( $connected_addon->get_slug(), 'failed to quiz add_entry_fields', $e->getMessage() );
			}

		}

		return $additional_fields_data;
	}


	/**
	 * Executor action for attached addons after entry saved on storage
	 *
	 * @see   Powerform_Addon_Quiz_Hooks_Abstract::after_entry_saved()
	 *
	 * @since 1.6.2
	 *
	 * @param                             $quiz_id
	 * @param Powerform_Form_Entry_Model $entry_model
	 */
	private function attach_addons_after_entry_saved( $quiz_id, Powerform_Form_Entry_Model $entry_model ) {
		//find is_form_connected
		$connected_addons = powerform_get_addons_instance_connected_with_quiz( $quiz_id );

		foreach ( $connected_addons as $connected_addon ) {
			try {
				$quiz_hooks = $connected_addon->get_addon_quiz_hooks( $quiz_id );
				if ( $quiz_hooks instanceof Powerform_Addon_Quiz_Hooks_Abstract ) {
					$quiz_hooks->after_entry_saved( $entry_model );// run and forget
				}
			} catch ( Exception $e ) {
				powerform_addon_maybe_log( $connected_addon->get_slug(), 'failed to quiz attach_addons_after_entry_saved', $e->getMessage() );
			}

		}
	}

	/**
	 * Check has lead skip
	 *
	 * @return bool
	 */
	public function has_skip_form() {
		$form_settings = isset( $this->model->settings ) ? $this->model->settings : array();

		if ( isset( $form_settings['skip-form'] ) && $form_settings['skip-form'] ) {

			return true;
		}

		return false;
	}
}
