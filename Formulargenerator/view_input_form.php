<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Dimitri Vranken" />

    <title>Vorschau - Formular-Generator</title>
    <link rel="shortcut icon" href="/media/icons/form.ico">

    <script src="http://code.jquery.com/jquery.js"></script>

    <script src="/scripts/js/bootstrap.min.js"></script>
    <link href="/style/css/bootstrap.css" rel="stylesheet" media="screen" />

    <link href="/style/css/style.css" rel="stylesheet" />
    <script src="/scripts/js/style.js" type="text/javascript"></script>
</head>
<body>
    <?php
    $validateParameters = true; //isset($_POST['submit']);
    
    if($validateParameters){
        $name = $_POST['name'];
        $server = $_POST['hostname'];
        $database = $_POST['database'];
        $table = $_POST['table'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    }
    ?>

    <?php require('/includes/warnings.inc.php'); ?>
    <?php require('/includes/navigation.inc.html'); ?>

    <div class="content">
        <div class="title-box text-center">
            <h1>Formular-Vorschau</h1>
        </div>
        <div class="container">
            <aside class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                <article>
                    <section>
                        <h2>Glückwunsch!</h2>
                        <p class="lead">
                            Ihr Formular wurde generiert und steht Ihnen zur freien Verwendung zur Verfügung.
                        </p>
                        <p class="lead">
                            Probieren Sie es direkt hier im Browser aus, laden Sie es sich herunter oder verwerfen Sie es und lassen Sie sich ein anderes Formulare generieren.
                        </p>
                    </section>
                    <section class="hidden-sm">
                        <h3>Informationen</h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Formularname:</td>
                                    <td><?php echo $name; ?></td>
                                </tr>
                                <tr class="new-section">
                                    <td>Hostname:</td>
                                    <td><?php echo $server; ?></td>
                                </tr>
                                <tr>
                                    <td>Datenbank:</td>
                                    <td><?php echo $database; ?></td>
                                </tr>
                                <tr>
                                    <td>Tabelle:</td>
                                    <td><?php echo $table; ?></td>
                                </tr>
                                <tr>
                                    <td>Benutzername:</td>
                                    <td><?php echo $username; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </article>
            </aside>
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 pull-right">
                <div class="frame" style="height: 500px;">
                    <?php
                    require_once('src\UserInterface\HtmlParameterValidator.php');
                    require_once('src\BusinessLogic\InputFormGenerator.php');
                    
                    $generateInputForm = false;
                    
                    if ($validateParameters) {
                        // Validate parameters
                        if (!\InputFormGenerator\UserInterface\HtmlParameterValidator::hasValue($name) ||
                            !\InputFormGenerator\UserInterface\HtmlParameterValidator::hasValue($server) ||
                            !\InputFormGenerator\UserInterface\HtmlParameterValidator::hasValue($database) || 
                            !\InputFormGenerator\UserInterface\HtmlParameterValidator::hasValue($table) |
                            !\InputFormGenerator\UserInterface\HtmlParameterValidator::hasValue($username)) {
                            
                            header('Location: /error.php');
                        }
                        
                        $generateInputForm = true;
                    }
                    
                    if ($generateInputForm) {
                        echo \InputFormGenerator\BusinessLogic\InputFormGenerator::generateInputForm($name, $server, $database, $table, $username, $password);
                    }
                    ?>
                </div>

                <form method="post" action="/scripts/php/download_input_form.php">
                    <input type="submit" value="Herunterladen" name="download" />
                </form>
                <input type="button" value="Verwerfen" onclick="if (confirm('Möchten Sie dieses Eingabeformular wirklich verwerfen?\nSie können es zu einem beliebigen Zeitpunkt erneut generieren lassen.')) { window.location = '/generate_input_form.php'; }" />
            </div>
        </div>
    </div>

    <?php require('/includes/footer.inc.html'); ?>
</body>
</html>