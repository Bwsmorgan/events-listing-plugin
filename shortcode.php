public function load_shortcode()
    {?>
        <div>

            <h1>Send us an email</h1>
            <p>Please Fill the below form</p>

            <form id="contact-form_form">

                <div class="form-group mb-2">
                    <input name="name" type="text" placeholder="Name" class="form-control">
                </div>

                <div class="form-group mb-2">
                    <input name="email" type="email" placeholder="Email" class="form-control">
                </div>

                <div class="form-group mb-2">
                    <input name="phone" type="tel" placeholder="Phone" class="form-control">
                </div> 

                <div class="form-group mb-2">
                    <textarea name="message" placeholder="Type your message" class="form-control"></textarea> 
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block w-100 ">Send Message</button>
                </div>

            </form>

        </div>

    <?php }

    function load_scripts()
    {?>
         <!-- <script>
            alert ("it works")
         </script> -->

    <?php }