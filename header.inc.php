<?php if (!@$has_header): $has_header = TRUE; ?>
<html>
<head>
    <title><?php echo htmlentities($title) ?></title>
    <link rel="icon" sizes="48x48" type="image/png" href="./favicon.png"/>
    <!--[if IE]>
    <link rel="shortcut icon" href="./favicon.ico"/>
    <![endif]-->
    <link rel="apple-touch-icon-precomposed" href="./apple-touch-icon.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="./apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./apple-touch-icon-114x114.png"/>
    <link rel="icon" sizes="57x57" type="image/png" href="./apple-touch-icon-57x57.png"/>
    <link rel="icon" sizes="72x72" type="image/png" href="./apple-touch-icon-72x72.png"/>
    <link rel="icon" sizes="114x114" type="image/png" href="./apple-touch-icon-114x114.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="//code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
    <style>
        .on{color:green}
        .off{color:red}
        .ui-header .ui-title {
            margin: 15px;
        }
        .charge_trickle, .charge_220, .charge_220_66 {
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <div data-role="page">
        <div data-role="header"><h1><?php echo htmlentities($title) ?></h1></div>
        <div data-role="content">
<?php endif; ?>
