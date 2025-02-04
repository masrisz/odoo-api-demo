<?php
    require_once('ripcord/ripcord.php');
    require_once('function.php');
    $env = include __DIR__ . '/config.php';

    $url = $env['APP_URL'];
    $db = $env['APP_DB'];
    $username = $env['APP_USERNAME'];
    $password = $env['APP_PASSWORD'];
    $apikey = $env['APP_APIKEY'];

    $common = ripcord::client("$url/xmlrpc/2/common");
    $common->version();

    $uid = $common->authenticate($db, $username, $password, array());

    $models = ripcord::client("$url/xmlrpc/2/object");

    $id_invoices = $models->execute_kw(
        $db,
        $uid,
        $password,
        'account.move',
        'search',
        array(array(array('state', '=', 'posted')))
    );

    $record_invoices = $models->execute_kw(
        $db,
        $uid,
        $password,
        'account.move',
        'read',
        array($id_invoices), // Menggunakan ID dari hasil search
        array('fields' => array('id', 'name', 'display_name', 'partner_id', 'invoice_line_ids'))
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is a basic HTML5 template">
    <meta name="author" content="Your Name">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="main">
        <header>
            <div class="container">
                <div class="inner">
                    <div class="logo-humburger d-none">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="40" fill="none" viewBox="0 0 100 40"><path fill="#1D2633" d="M4.77 4.235C5.03 3.001 6.26 2 7.513 2h6.812L8.66 28.823H1.848c-1.254 0-2.06-1-1.799-2.235L4.77 4.235ZM27.477 4.235C27.738 3.001 28.967 2 30.22 2h6.812l-5.665 26.823h-6.812c-1.254 0-2.06-1-1.799-2.235l4.721-22.353ZM72.892 4.235C73.152 3.001 74.38 2 75.635 2h6.812l-5.665 26.823h-6.813c-1.254 0-2.059-1-1.798-2.235l4.72-22.353ZM39.303 2h6.812c1.254 0 2.06 1 1.799 2.235l-4.721 22.353c-.26 1.235-1.489 2.235-2.743 2.235h-6.812L39.303 2ZM84.718 2h6.812c1.254 0 2.06 1 1.799 2.235l-4.722 22.353c-.26 1.235-1.488 2.235-2.742 2.235h-6.813L84.718 2ZM50.185 4.235C50.445 3.001 51.673 2 52.927 2h6.813l-5.666 26.823h-6.812c-1.254 0-2.06-1-1.798-2.235l4.72-22.353ZM62.01 2h6.813c1.254 0 2.059 1 1.798 2.235l-7.081 33.53C63.278 38.999 62.05 40 60.796 40h-6.813L62.01 2ZM12.819 19.882h9.083l-1.416 6.706c-.261 1.235-1.49 2.235-2.743 2.235H10.93l1.888-8.94ZM44.52 31.059h9.082L51.714 40h-6.812c-1.255 0-2.06-1-1.799-2.235l1.416-6.706ZM69.174 33.138l-1.15 5.446c-.05.234-.128.298-.366.298h-.523c-.238 0-.29-.064-.24-.298l1.15-5.446c.05-.233.128-.298.366-.298h.523c.238 0 .29.065.24.298ZM70.686 36.812h-.107c-.114 0-.154.032-.177.145l-.344 1.627c-.05.234-.129.298-.366.298h-.524c-.237 0-.289-.064-.24-.298l1.15-5.446c.05-.233.13-.298.367-.298h1.08c1.244 0 1.715.443 1.485 1.53l-.192.911c-.23 1.088-.888 1.53-2.132 1.53Zm.316-2.699-.3 1.426c-.025.113.001.145.116.145h.172c.4 0 .615-.161.702-.572l.12-.572c.087-.41-.059-.572-.46-.572h-.172c-.114 0-.154.032-.178.145ZM74.74 34.991l.85.935c.446.483.508.773.394 1.313l-.03.145c-.215 1.015-.727 1.579-1.914 1.579-1.186 0-1.479-.475-1.205-1.773l.034-.16c.05-.234.129-.299.366-.299h.556c.238 0 .29.065.24.298l-.075.355c-.068.322.036.451.322.451.287 0 .443-.12.505-.41l.032-.154c.048-.226.022-.338-.224-.604l-.8-.862c-.448-.475-.505-.75-.391-1.29l.037-.176c.215-1.015.727-1.58 1.913-1.58 1.187 0 1.48.476 1.206 1.773l-.034.161c-.05.234-.129.298-.366.298h-.557c-.237 0-.289-.064-.24-.298l.075-.354c.068-.323-.035-.451-.322-.451-.286 0-.443.12-.504.41l-.029.137c-.05.234-.024.347.161.556ZM79.532 33.138c.05-.233.128-.298.366-.298h.523c.238 0 .29.065.24.298l-.856 4.053c-.274 1.297-.767 1.772-1.954 1.772-1.186 0-1.479-.475-1.205-1.773l.856-4.052c.05-.233.129-.298.366-.298h.524c.237 0 .289.065.24.298l-.897 4.246c-.068.322.044.451.355.451.302 0 .477-.129.545-.451l.897-4.246ZM82.938 36.417c.003.065.024.08.065.08.04 0 .069-.015.099-.08l1.414-3.367c.069-.17.151-.21.356-.21h.794c.237 0 .289.065.24.298l-1.15 5.446c-.05.234-.13.298-.367.298h-.376c-.237 0-.29-.064-.24-.298l.552-2.61c.015-.072.002-.089-.047-.089-.033 0-.07.017-.09.073l-1.142 2.659c-.082.193-.187.265-.424.265H82.4c-.246 0-.32-.072-.32-.265l-.028-2.66c-.005-.056-.018-.072-.059-.072-.049 0-.069.017-.084.089l-.551 2.61c-.05.234-.128.298-.366.298h-.376c-.238 0-.29-.064-.24-.298l1.15-5.446c.05-.233.129-.298.366-.298h.68c.286 0 .378.065.376.347l-.011 3.23ZM100 2c0 1.105-.89 2-1.987 2a1.993 1.993 0 0 1-1.987-2c0-1.105.89-2 1.987-2S100 .895 100 2Z"></path></svg>
                        </div>
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <nav class="menu d-none">
                        <ul>
                            <li><a ui-sref="home">Home</a></li>
                            <li><a ui-sref="aboutus">Add Record</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="list-group mt-4">
                        <?php foreach($record_invoices as $key => $item){?>
                            <?php $id_inv = $item['id'];?>
                            <li class="list-group-item">
                                <div class="mt-0 d-flex justify-content-between">
                                    <h5><?php echo $item['display_name']; ?></h5>
                                    <a class="d-none" href="?action=delete&id_invoice=<?php echo $item['id']; ?>"><i class="fa fa-trash text-danger" style="cursor: pointer;"></i></a>
                                </div>
                                
                                <div class="card p-2">
                                    <p class="mb-0">Customer: <?php echo $item['partner_id'][1]; ?></p>

                                    <?php
                                        $invoice_lines = $models->execute_kw(
                                            $db,
                                            $uid,
                                            $password,
                                            'account.move.line',
                                            'search_read',
                                            array(
                                                array(array('move_id', '=', $item['id'])) // Ambil lines berdasarkan ID Invoice
                                            ),
                                            array(
                                                'fields' => array(
                                                    'id', 
                                                    'product_id', 
                                                    'name', 
                                                    'quantity', 
                                                    'price_unit', 
                                                    'price_subtotal', 
                                                    'price_total'
                                                )
                                            )
                                        );

                                        foreach($invoice_lines as $key => $line){
                                    ?>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0">Line Info <?php echo $key + 1; ?> : <?php echo $line['name'];?></p>

                                        <?php if($line['product_id'] != false){ ?>
                                            <p class="mb-0">Line Info (Price) : <?php echo $line['price_unit'];?></p>
                                            <p class="mb-0">Line Info (qty) : <?php echo $line['quantity'];?></p>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            <li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <p>&copy; 2025 masmun.my.id All Rights Reserved.</p>
            </div>
        </footer>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="scripts.js" defer></script>
</body>
</html>
