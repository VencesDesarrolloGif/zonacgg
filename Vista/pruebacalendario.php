<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>

    <title>Multiple day picker</title>

    <script src="js/jquery-1.11.2.min.js"></script>

    <!-- Mobiscroll JS and CSS Includes -->
    <link rel="stylesheet" href="js/mobiscroll.jquery.min.css">
    <script src="js/mobiscroll.jquery.min.js"></script>

    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    body,
    html {
        height: 100%;
    }

    </style>

</head>
<body>

<div mbsc-page class="demo-multiple-day-selection">
  <div style="height:100%">
      
    <div mbsc-form>
        <div class="mbsc-grid">
            <div class="mbsc-row">
                <div class="mbsc-col-sm-12 mbsc-col-md-4">
                    <div class="mbsc-form-group">
                        <div class="mbsc-form-group-title">Multi-day</div>
                        <div id="demo-multi-day"></div>
                    </div>
                </div>
                <div class="mbsc-col-sm-12 mbsc-col-md-4">
                    <div class="mbsc-form-group">
                        <div class="mbsc-form-group-title">Max days</div>
                        <div id="demo-max-days"></div>
                    </div>
                </div>
                <div class="mbsc-col-sm-12 mbsc-col-md-4">
                    <div class="mbsc-form-group">
                        <div class="mbsc-form-group-title">Counter</div>
                        <div id="demo-counter"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
  </div>
</div>

<script>

    mobiscroll.settings = {
        lang: 'en',                          // Specify language like: lang: 'pl' or omit setting to use default
        theme: 'ios',                        // Specify theme like: theme: 'ios' or omit setting to use default
            themeVariant: 'light'            // More info about themeVariant: https://docs.mobiscroll.com/4-10-7/calendar#opt-themeVariant
    };
    
    $(function () {
    
        // Mobiscroll Calendar initialization
        $('#demo-multi-day').mobiscroll().calendar({
            display: 'inline',               // Specify display mode like: display: 'bottom' or omit setting to use default
            select: 'multiple'               // More info about select: https://docs.mobiscroll.com/4-10-7/calendar#opt-select
        });
    
        // Mobiscroll Calendar initialization
        $('#demo-max-days').mobiscroll().calendar({
            display: 'inline',               // Specify display mode like: display: 'bottom' or omit setting to use default
            select: 5,                       // More info about select: https://docs.mobiscroll.com/4-10-7/calendar#opt-select
            headerText: 'Pick up to 5 days'  // More info about headerText: https://docs.mobiscroll.com/4-10-7/calendar#opt-headerText
        });
    
        // Mobiscroll Calendar initialization
        $('#demo-counter').mobiscroll().calendar({
            display: 'inline',               // Specify display mode like: display: 'bottom' or omit setting to use default
            select: 'multiple',              // More info about select: https://docs.mobiscroll.com/4-10-7/calendar#opt-select
            counter: true                    // More info about counter: https://docs.mobiscroll.com/4-10-7/calendar#opt-counter
        });
    
    });
</script>

</body>
</html>
