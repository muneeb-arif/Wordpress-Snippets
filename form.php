<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="alert form-message"></div>

<form class="question_form" id="question_form" role="form" method="post">

    <input type="hidden" name="action" value="submit_question">
    <?php wp_nonce_field('submit-question'); ?>

    <div class="form-group">
        <label for="name">Name <span class="mandatory">*</span> </label>
        <input type="text" class="form-control" name="first_name" id="name" placeholder="Enter name" required>
    </div>

    <div class="form-group">
        <label for="name">Email address <span class="mandatory">*</span> </label>
        <input type="email" class="form-control" id="email" name="user_email" placeholder="Enter Email Address" required>
    </div>

    <div class="form-group">
        <label for="name">Phone#</label>
        <input type="text" class="form-control" id="phone" name="_phone" placeholder="Enter Phone#">
    </div>

    <div class="form-inline">
        <legend>Gender</legend>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_gender" value="male" checked>
                Male
            </label>
        </div>
        &nbsp;
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_gender" value="female">
                Female
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="number" min="5" max="200" class="form-control" id="age" name="_age" placeholder="Enter Age">
    </div>

    <div class="form-group">
        <label for="country">Country</label>
         <?php the_countries(array('class'=>'form-control', 'id'=>'country', 'name' => '_country')); ?>
    </div>

    <div class="form-inline">
        <legend>Arabic</legend>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_arabic" value="1">
                Yes
            </label>
        </div>
        &nbsp;
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_arabic" value="0" checked>
                No
            </label>
        </div>

        <div>
            <small class="form-text text-muted">If your question is answered in Arabic, can you read it?</small>
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_read_arabic" value="1">
                Yes
            </label>
        </div>
        &nbsp;
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="_read_arabic" value="0" checked>
                No
            </label>
        </div>
    </div>

    <br />
    <div class="form-group">
        <label for="category">Category <span class="mandatory">*</span> </label>
        <select name="category" id="category" class="form-control">
            <?php foreach($post_terms as $t) { ?>
                <option value="<?php echo($t['id']);?>">
                    <?php echo($t['name']);?>
                </option>
            <?php }?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">Subject <span class="mandatory">*</span> </label>
        <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter your Subject" required>
    </div>

    <div class="form-group">
        <label for="question">Question <span class="mandatory">*</span> </label>
        <textarea class="form-control" name="_question" id="question" rows="6" cols="10" required></textarea>
        <small class="form-text text-muted">Maximum 500 characters</small>
    </div>

    <div class="form-group">
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="_private" class="form-check-input" value="1">
                Keep Private (if checked the question won't be published online)
            </label>
        </div>
    </div>

    <div class="form-group">
        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
        <div class="g-recaptcha" data-sitekey=""></div>
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" name="_submit" id="form_submit" />
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ajax-loader.gif" class="form-submit-loader" style="display: none" />
    </div>
	
</form>