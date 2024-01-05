<?php
    include_once("controller/apps.php");
    include_once("./controller/validator.php");

    $appId = "";
    $apiKey = "";

    if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST["app_id"];
        $key = $_POST["api_key"];

        if(validateAppId($id) || validateApiKey($key)) {
            $appId = $id;
            $apiKey = $key;
        }
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="QLBase" />
    <meta name="keywords" content="nthnn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>API Sandbox</title>

    <link href="./favicon.ico" rel="shortcut icon" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/global.css" rel="stylesheet" />

    <style>
        #receiver, #contents, #http-headers { resize: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand text-white">QLBase API Sandbox</span>
        </div>
    </nav>

    <div class="mt-4 container">
        <div class="row">
            <div class="col-lg-6">
                <i>API Action:</i>
                <select id="action" class="form-control">
                </select>
                <br/>

                <i>Contents:</i>
                <textarea cols="70" rows="7" id="contents" class="form-control" placeholder="Request Contents" spellcheck="false">{}</textarea>
                <br/>

                <i>HTTP Headers:</i>
                <textarea cols="70" rows="7" id="http-headers" class="form-control" placeholder="HTTP Headers" spellcheck="false">{&#10;&#9;"QLBase-API-Key": "<?php echo $apiKey; ?>",&#10;&#9;"QLBase-App-ID": "<?php echo $appId; ?>"&#10;}</textarea>
                <br/>

                <button class="btn btn-primary" id="send">Send Request</button>
                <div class="mobile-only">
                    <br/><hr/>
                </div>
            </div>

            <div class="col-lg-6">
                <i>Response:</i>
                <textarea cols="70" rows="20" id="response" class="form-control" disabled></textarea>

                <div class="mobile-only">
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/vendors/bootstrap.bundle.min.js"></script>
    <script src="scripts/vendors/jquery.min.js"></script>
    <script src="scripts/rotating-button.js"></script>
    <script src="scripts/sandbox.js"></script>
</body>