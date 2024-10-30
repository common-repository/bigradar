<?php

class BigRadarSettings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->options = get_option('bigradar') ?: ['app_id' => ''];
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        if ($this->options['app_id']) {
            add_action('wp_footer', [ $this, 'add_footer' ]);
        }
    }

    public function add_footer()
    {
        ?>
    <!-- BigRadar --><script type="text/javascript">(function(d,c) {
            var b = d.body.appendChild(d.createElement('div')),
                f=b.appendChild(d.createElement('iframe'));
                b.style.display='none';f.src="";
            f.onload = function() {
                var fw=f.contentWindow,
                fd=f.contentDocument,
                s=fd.body.appendChild(fd.createElement('script'));
                fw.widget={frame:f,container:b,config:c};s.src='https://app.bigradar.io/widget.js';
            };
            return b;
        })(document, {
            app_id: '<?= $this->options['app_id'] ?>',
            // name: '<name>',
            // email: '<email>',
        });</script><!-- End BigRadar -->
        <?php
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page(
            'BigRadar Settings', 
            'BigRadar Chat', 
            'manage_options', 
            'bigradar-setting', 
            array( $this, 'create_admin_page' ),
            'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MC43IDQ4LjA4Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzJmODBlYTt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmJpZ3JhZGFyPC90aXRsZT48cGF0aCBpZD0iX0NvbXBvdW5kX1BhdGhfIiBkYXRhLW5hbWU9IiZsdDtDb21wb3VuZCBQYXRoJmd0OyIgY2xhc3M9ImNscy0xIiBkPSJNMjI2Ni4wOC0zNDkuNTVjLTE0LDAtMjUuMzUsMTAuMTgtMjUuMzUsMjIuNzNhMjEsMjEsMCwwLDAsNC4xOSwxMi41MmMtMC4zNSw0LjE0LTEuMzUsMTAtNC4xOSwxMi44MywwLDAsOC42OS0xLjIyLDE0LjU4LTQuNzhhMjcuNjcsMjcuNjcsMCwwLDAsMTAuNzcsMi4xNWMxNCwwLDI1LjM1LTEwLjE3LDI1LjM1LTIyLjcyUzIyODAuMDgtMzQ5LjU1LDIyNjYuMDgtMzQ5LjU1Wm0tNi44NCwzMy40NGEyLjU3LDIuNTcsMCwwLDEtMi41Ni0yLjU2LDIuNTcsMi41NywwLDAsMSwyLjU2LTIuNTYsMi41NywyLjU3LDAsMCwxLDIuNTYsMi41NkEyLjU3LDIuNTcsMCwwLDEsMjI1OS4yNC0zMTYuMTJabTguMTItMS4yOGExLjI4LDEuMjgsMCwwLDEtMS4yOC0xLjI4LDYuODQsNi44NCwwLDAsMC02Ljg0LTYuODQsMS4yOCwxLjI4LDAsMCwxLTEuMjgtMS4yOCwxLjI4LDEuMjgsMCwwLDEsMS4yOC0xLjI4LDkuMzQsOS4zNCwwLDAsMSw2LjY1LDIuNzUsOS4zNCw5LjM0LDAsMCwxLDIuNzUsNi42NUExLjI4LDEuMjgsMCwwLDEsMjI2Ny4zNi0zMTcuNFptNi44NCwwYTEuMjgsMS4yOCwwLDAsMS0xLjI4LTEuMjgsMTMuNjksMTMuNjksMCwwLDAtMTMuNjctMTMuNjcsMS4yOCwxLjI4LDAsMCwxLTEuMjgtMS4yOCwxLjI4LDEuMjgsMCwwLDEsMS4yOC0xLjI4LDE2LjEzLDE2LjEzLDAsMCwxLDYuMzIsMS4yOCwxNi4xOCwxNi4xOCwwLDAsMSw1LjE2LDMuNDgsMTYuMTgsMTYuMTgsMCwwLDEsMy40OCw1LjE2LDE2LjEzLDE2LjEzLDAsMCwxLDEuMjgsNi4zMkExLjI4LDEuMjgsMCwwLDEsMjI3NC4yLTMxNy40WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIyNDAuNzMgMzQ5LjU1KSIvPjwvc3ZnPg==',
            20
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        ?>
        <div class="wrap">
            <h1>BigRadar - Live Chat Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'bigradar' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'bigradar', // Option group
            'bigradar' // Option name
        );

        add_settings_section(
            'setting_section_id', // ID
            'Start getting messages from your visitors. ', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'app_id', 
            'App ID', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Step by step guide to setup BigRadar Live Chat on your website';
        ?>
        <ul>
            <li>Step 1: <a href="https://app.bigradar.io/register" target="bigradar">Create your account on BigRadar</a></li>
            <li>Step 2: Complete the signup process as per instruction on the screen.</a></li>
            <li>Step 3: Copy the App ID from Settings > Project and paste in the below field.</a></li>
        </ul>
        <!-- <form method="post" action="https://app.bigradar.io/register">
            <input type="text" placeholder="Official Email" name="email">
            <button type="submit" class="button button-primary">Get Started</button>
        </form> -->
        <!-- BigRadar --><script type="text/javascript">(function(d,c) {
            var b = d.body.appendChild(d.createElement('div')),
                f=b.appendChild(d.createElement('iframe'));
                b.style.display='none';f.src="";
            f.onload = function() {
                var fw=f.contentWindow,
                fd=f.contentDocument,
                s=fd.body.appendChild(fd.createElement('script'));
                fw.widget={frame:f,container:b,config:c};s.src='https://app.bigradar.io/widget.js';
            };
            return b;
        })(document, {
            app_id: 'zjjhckicHgwrgWJ3rI2bGWxI',
            // name: '<name>',
            // email: '<email>',
        });</script><!-- End BigRadar -->
        <?php
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="bigradar[app_id]" value="%s" placeholder="App ID" />',
            $this->options['app_id']
        );
    }
}
