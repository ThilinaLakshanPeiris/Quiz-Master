<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EditQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel');
        $this->load->model('updateQuizModel');
        $this->load->model('createQuizModel');
    }

    public function edit_quiz_view($quizId)
    {
        $quiz = $this->viewQuizModel->get_complete_quiz($quizId);

        $data['quiz'] = $quiz;
        $this->load->view('Admin/editQuiz', $data);
    }

    public function update_quiz($quizId)
    {
        $updateData = file_get_contents("php://input");

        $jsonData = json_decode($updateData, true);

        // echo json_encode($jsonData);

        $query = $this->updateQuizModel->check_update_quiz_id($quizId);

        if ($query && !empty($updateData)) {
            // echo json_encode("The quiz id exists!");

            // $user_id = $jsonData['user_id'];
            $quizName = $jsonData['quiz_name'];
            $quizCategory = $jsonData['quiz_category'];
            $questions = $jsonData['questions'];

            $categoryId = $this->createQuizModel->get_category_id($quizCategory);

            if ($categoryId) {
                if ($this->updateQuizModel->update_quiz($quizId, $quizName, $categoryId)) {
                    // echo json_encode("Updated the quiz successfully!");

                    // echo json_encode($questions);

                    foreach ($questions as $question) {
                        try {
                            $questionText = $question['question_text'];
                            $question_id = $question['question_id'];
                            $answers = $question['answers'];

                            // echo json_encode($questionText); 
                            // echo json_encode($answers); 

                            if ($this->updateQuizModel->update_question($quizId, $question_id, $questionText)) {
                                foreach ($answers as $answer) {
                                    $answerText = $answer['answer_text'];
                                    $answerid = $answer['answer_id'];
                                    $isCorrect = $answer['is_correct'];

                                    $this->updateQuizModel->update_answer($question_id, $answerid, $answerText, $isCorrect);
                                }
                            } else {
                                echo json_encode("Error while updating question table");
                            }
                        } catch (Exception $e) {
                            echo json_encode("Error: " . $e->getMessage());
                        }
                    }
                    // echo json_encode("Quiz updated successfully!");
                } else {
                    echo json_encode("Error while updating quiz table");
                }
            }
            echo json_encode("Quiz updated successfully!");
        } else {
            echo json_encode("This quiz id does not exist!");
        }
    }
}
