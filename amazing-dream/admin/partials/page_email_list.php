<div class='wrap'>  
        <h2>WordPress Form </h2>  
        <div class="main-content">  
  
        <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
            <input type="hidden" name="action" value="submit_form_data">
            <input type="text" name="post_title">
            <textarea name="post_content" rows="10" cols="30">
            
            </textarea>
            <?php wp_nonce_field('personalFormData', 'securityNonce'); ?>
            <?php echo get_submit_button('Submit'); ?>
        </form>
  
    </div>  
          
       </div>  