<?php

require_once(__DIR__ . '/vendor/autoload.php');

$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c83699iad3ift3bm2ig0');
$client = new Finnhub\Api\DefaultApi(
    new GuzzleHttp\Client(),
    $config
);

$search = $_GET['search'] ?? '';
$favourites = ['AAPL', 'MSFT', 'AMZN', 'VMEO'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock information</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <h1 align="center">Stock exchange information</h1>
</header>
<body>
    <div align="center">
        <?php foreach($favourites as $company) {
            $difference = $client->quote($company)->getC() - $client->quote($company)->getPc()?>
            <div class="box">
                <p><?php echo $client->companyProfile2($company)->getTicker()?></p>
                <p><?php echo round($client->quote($company)->getC(),2)?>$</p>
                <?php if($difference < 0) { ?>
                <p style="color:red"><?php echo number_format($difference,2)?>$</p>
                <?php } else { ?>
                <p style="color:green"><?php echo number_format($difference,2)?>$</p>
                <?php } ?>
            </div>

        <?php }; ?>
    </div>
    <br>
<div align="center">
    <form method="get" action="/">
        <input type= "text" name="search" placeholder="Type stock symbol"/>
        <button type="submit">Search</button>
    </form>
    <br>
</div>

    <div align="center">
        <?php $difference = $client->quote($search)->getC() - $client->quote($search)->getPc()?>
        <div class="box">
            <p><?php echo $client->companyProfile2($search)->getTicker()?></p>
            <p><?php echo round($client->quote($search)->getC(),2)?>$</p>
            <?php if($difference < 0) { ?>
                <p style="color:red"><?php echo number_format($difference,2)?>$</p>
            <?php } else { ?>
                <p style="color:green"><?php echo number_format($difference,2)?>$</p>
            <?php } ?>
        </div>
    </div>

</body>
</html>

