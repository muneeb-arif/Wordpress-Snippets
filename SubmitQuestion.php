<?php

class SubmitQuestion {

    private $user_email;
    private $first_name;
    private $phone;
    private $gender;
    private $age;
    private $country;
    private $arabic;
    private $read_arabic;
    private $question;
    private $category;
    private $subject;
    private $private;
    private $nonce;
    
    public function __construct($form_data) {
        
        $this->user_email = sanitize_text_field($form_data['user_email']);
        $this->first_name = sanitize_text_field($form_data['first_name']);
        $this->phone = sanitize_text_field($form_data['_phone']);
        $this->gender = sanitize_text_field($form_data['_gender']);
        $this->age = sanitize_text_field($form_data['_age']);
        $this->country = sanitize_text_field($form_data['_country']);
        $this->arabic = sanitize_text_field($form_data['_arabic']);
        $this->read_arabic = sanitize_text_field($form_data['_read_arabic']);
        $this->question = sanitize_text_field($form_data['_question']);
        $this->category = sanitize_text_field($form_data['category']);
        $this->subject = sanitize_text_field($form_data['subject']);
        $this->nonce = $form_data['_wpnonce'];
        $this->private = 0;
        
        if(!empty($form_data['_private']))
            $private = $form_data['_private'];
    }

    public function validate_fields() {
        // check email
        if(empty($this->user_email))
            die(json_encode(array(
                'status' => 0,
                'message' => 'Email Address cannot be empty'
            )));

        // check name
        if(empty($this->first_name))
            die(json_encode(array(
                'status' => 0,
                'message' => 'Name cannot be empty'
            )));

        // check $subject
        if(empty($this->subject))
            die(json_encode(array(
                'status' => 0,
                'message' => 'Subject cannot be empty'
            )));

        // check $question
        if(empty($this->question))
            die(json_encode(array(
                'status' => 0,
                'message' => 'Question cannot be empty'
            )));

        $this->security_check();
    }

    private function get_user() {
        // check if user exists
        if(email_exists($this->user_email)) {
            $user = get_user_by('email', $this->user_email);
        } else {
            $user = wp_insert_user( array(
                'user_email' => $this->user_email,
                'user_login' => $this->user_email,
                'display_name' => $this->first_name,
                'first_name' => $this->first_name,
                'user_pass' => $this->user_email,
                'role' => 'author',
            ));
        }

        return $user;
    }

    public function insert_form_data() {

        // insert post
        $post_data = array(
            'post_author' => (int) $this->get_user()->data->ID,
            'post_title' => $this->subject,
            'post_status' => 'pending',
            'post_type' => 'my_posts',
            'meta_input' => array(
                'phone' => ($this->phone),
                'gender' => ($this->gender),
                'country' => ($this->country),
                'arabic' => ($this->arabic),
                'read_arabic' => ($this->read_arabic),
                'question' => ($this->question),
                'private' => $this->private,
                'age' => $this->age,
                'question_by_name' => $this->first_name,
                'question_by_email' => $this->user_email
            )
        );
        $post_id = wp_insert_post($post_data, true);
        if(is_object($post_id))
            die(json_encode(array(
                'status' => 0,
                'message' => $post_id
            )));

        wp_set_post_terms($post_id, array($this->category), 'fatwa');

        die(json_encode(array(
            'status' => 1,
            'message' => 'Your Question is submitted successfully. You will be notified when it is answered. Thank you!'
        )));
    }

    private function security_check() {
        if ( ! wp_verify_nonce( $this->nonce, 'submit-question' ) ) {
            die(json_encode(array(
                'status' => 0,
                'message' => 'Security Check Failed! Your IP has been blocked for any future submits!'
            )));
        }

    }
}