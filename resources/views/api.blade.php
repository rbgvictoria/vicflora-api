<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Flora of Victoria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="shortcut icon" href="https://www.rbg.vic.gov.au/common/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://www.rbg.vic.gov.au/common/fonts/451576/645A29A9775E15EA2.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/third_party/openlayers/3.18.1/ol.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/css/styles.1480398372.css" />
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/css/jqueryui.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/css/vicflora.1472350789.css" />
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/third_party/bower_components/photoswipe/dist/photoswipe.css" />
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/third_party/bower_components/photoswipe/dist/default-skin/default-skin.css" />
    <link rel="stylesheet" type="text/css" href="https://vicflora.rbg.vic.gov.au/dev/css/swagger-ui/swagger-ui.css" >
    <style>
        #swagger-ui pre {
            padding: 0;
            border: none;
            background-color: transparent;
        }
        
        #swagger-ui .scheme-container {
            background-color: transparent;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        
        .swagger-ui .opblock.opblock-get {
            border-color: rgb(187, 157, 19);
            background: rgba(241, 235, 208,.1);
        }
        
        .swagger-ui .opblock.opblock-get .opblock-summary {
            border-color: rgb(187, 157, 19);
            background-color: rgba(187, 157, 19, .5);
        }
    </style>

    

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!--script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/bower_components/jquery/dist/jquery.min.js"></script-->
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <!--script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/jquery-ui/js/jquery-ui.min.js"></script-->
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/openlayers/3.18.1/ol.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/js/jquery.vicflora.ol3.1490165930.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/bower_components/jspath/jspath.min.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/keybase/js/jquery.keybase.key.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/js/vicflora.1475449573.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/js/vicflora-keybase.1472609616.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/bower_components/photoswipe/dist/photoswipe.min.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/third_party/bower_components/photoswipe/dist/photoswipe-ui-default.min.js"></script>
    <script type="text/javascript" src="https://vicflora.rbg.vic.gov.au/js/vicflora.photoswipe.1472714728.js"></script>

</head>
<body class="swagger-section vicflora">
    <div id="banner">
        <div class="container">
              <div class="row">
                  <div class="col-lg-12 clearfix">
                    <ul class="social-media">
                        <li><a href="https://twitter.com/RBG_Victoria" target="_blank"><span class="icon icon-twitter-solid"></span></a></li>
                        <li><a href="https://www.facebook.com/BotanicGardensVictoria" target="_blank"><span class="icon icon-facebook-solid"></span></a></li>
                        <li><a href="https://instagram.com/royalbotanicgardensvic/" target="_blank"><span class="icon icon-instagram-solid"></span></a></li>
                    </ul>
                  </div> <!-- /.col -->

                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand">
                            <a class="brand-rbg" href="http://www.rbg.vic.gov.au"><img src="https://vicflora.rbg.vic.gov.au/images/rbg-logo-with-text.png" alt=""/></a>
                            <a class="brand-vicflora" href="https://vicflora.rbg.vic.gov.au/">VicFlora</a>
                        </div>
                    </div>

                    <div id="navbar" class="navbar-collapse collapse">
                      <ul class="nav navbar-nav">
                          <li class="home-link"><a href="https://vicflora.rbg.vic.gov.au/"><span class="glyphicon glyphicon-home"></span></a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/search">Search</a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/classification">Browse classification</a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/key/1903" class="colorbox_mainkey">Keys</a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/checklist">Checklists</a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/glossary">Glossary</a></li>
                        <li><a href="https://vicflora.rbg.vic.gov.au/flora/bioregions">Bioregions & Vegetation</a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Help <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="https://vicflora.rbg.vic.gov.au/flora/help">Help</a></li>
                            <li><a href="https://vicflora.rbg.vic.gov.au/flora/about">About</a></li>
                            <li><a href="https://vicflora.rbg.vic.gov.au/flora/acknowledgements">Acknowledgements</a></li>
                          </ul>
                        </li>
                      </ul>
                      <form action="https://vicflora.rbg.vic.gov.au/flora/search" accept-charset="utf-8" method="get" class="navbar-form navbar-right">                    <div class="form-group">
                            <div class="input-group">
                          <input type="text" name="q" value="" class="form-control input-sm" placeholder="Enter taxon name..."  />                            <div class="submit input-group-addon"><i class="fa fa-search fa-lg"></i></div>
                            </div>
                        </div>

                      </form>                </div><!--/.navbar-collapse -->
                </nav>

                <div class="col-lg-12">
                    <div id="header">
                        <div class="login">
                            <a href="https://vicflora.rbg.vic.gov.au/admin/login" id="hidden-login-link">Log in</a>
                        </div>
                        <div id="logo">
                            <a href='http://www.rbg.vic.gov.au'>
                                <img class="img-responsive" src="https://vicflora.rbg.vic.gov.au/images/rbg-logo-with-text" alt="" />
                            </a>
                        </div>
                        <div id="site-name">
                            <a href="https://vicflora.rbg.vic.gov.au/">VicFlora</a>
                        </div>
                        <div id="subtitle">Flora of Victoria</div>
                    </div>
                </div>
            </div><!--/.row -->
        </div><!--/.container -->
    </div> <!-- /#banner -->

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="swagger-ui"></div>
            </div>
        </div>
    </div>
    
    <script src="https://vicflora.rbg.vic.gov.au/dev/js/swagger-ui/swagger-ui-bundle.js"> </script>
    <script>
    window.onload = function() {

      // Build a system
      const ui = SwaggerUIBundle({
        url: "https://vicflora.rbg.vic.gov.au/api?format=json",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis
        ],
        docExpansion: "list",
        plugins: [
          SwaggerUIBundle.plugins.DownloadUrl
        ],
        defaultModelRendering: "model",
        apisSorter: "alpha",
        operationsSorter: "method",
        jsonEditor: true
      })

      window.ui = ui
    }
    </script>

</body>
</html>