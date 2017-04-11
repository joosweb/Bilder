<?php
error_reporting(0);
if ($_SESSION['email']) {
	include('src/BarcodeGenerator.php');
	include('src/BarcodeGeneratorHTML.php');
	$generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
    $cadena_encriptada   = $_GET['document'];
    $cadena_desencryptada = Encrypter::decrypt($cadena_encriptada);
    $pdo                  = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    $stm5 = $pdo->prepare("SELECT * FROM solicitude INNER JOIN certified_autorized ON certified_autorized.id_solicitud=solicitude.id WHERE certified_autorized.numero_seguridad=?");
    $stm5->execute(array($cadena_desencryptada));
    $rowss           = $stm5->fetch(PDO::FETCH_OBJ);
    $exp_date       = $rowss->expiracion;
    $todays_date     = date("Y-m-d");
    $today           = strtotime($todays_date);
    $expiration_date = strtotime($exp_date);

    // OBTENER NOMBRES SEGUN RUT
    $uri     = "http://chile.rutificador.com/get_generic_ajax/";
    $headers = [
        'Cookie: csrftoken=ioAfP80sm4cafdC8qgT9OoeCFb53KXGh;',
        'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
    ];
    $data = [
        'csrfmiddlewaretoken' => 'ioAfP80sm4cafdC8qgT9OoeCFb53KXGh',
        'entrada'             => $rowss->rut_solicitado,
        //'entrada' => '18765525-0'
    ];
    $data = http_build_query($data);
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch); #Enviamos una petición curl y el resultado lo almacenamos en '$response'
    curl_close($ch);
    $data = json_decode(utf8_encode($response), true);
    foreach ($data as $value) {
        foreach ($value as $f) {
            $name = $f['name'];
            $rut  = $f['rut'];
        }
    }
    $porciones = explode(" ", $name);
    $nombres   = $porciones[2] . ' ' . $porciones[3];
    $apellidos = $porciones[0] . ' ' . $porciones[1];

    ///////////////////////////////////////

    $query2 = $pdo->prepare("SELECT * FROM debtor WHERE rut = ? and estado=1");
    $query2->execute(array($rowss->rut_solicitado));
    $return = '';
    $i      = 1;
    while ($deudas = $query2->fetch(PDO::FETCH_OBJ)) {

    	if($deudas->numero_causa == '') {
    		$causa = '-- --';
    	}
    	else {
    		$causa = $deudas->numero_causa;
    	}

        $return = $return . '<tr>';
        $return = $return . '<td align="center">' . $i++ . '</td>';
        $return = $return . '<td align="center">' . $deudas->direccion_propiedad . '</td>';
        $return = $return . '<td align="center">' . $deudas->region . '</td>';
        $return = $return . '<td align="center">' . $deudas->comuna . '</td>';
        $return = $return . '<td align="center">' . $deudas->denuncia_cursada . '</td>';
        $return = $return . '<td align="center">' . $causa . '</td>';
        $return = $return . '</tr>';
    }
    // PREGUNTAR SI TIENE REGISTROS
    $query = $pdo->prepare("SELECT * FROM debtor WHERE rut = ? and estado=1");
    $query->execute(array($rowss->rut_solicitado));
    $fetch = $query->fetch(PDO::FETCH_OBJ);
    // FIN PREGUNTAR SI TIENE REGISTROS
    if ($expiration_date >= $today) {
        if (@$fetch->id) {
            /// CREAR CERTIFICADO + DATOS ADJUNTOS
            if (htmlentities($_GET['document'])) {
                require_once "dompdf_config.inc.php";
                $dompdf = new DOMPDF();

                $html = '<!DOCTYPE html>
						<html>
						<head lang="en">
					    <meta charset="UTF-8">
					    <title>bilder.cl</title>
					    <style>
					        body{
					            font-family: arial, helvetica, sans-serif;
					            color: #000;
					            background: #fff;
					            padding:40px;
					            text-align: center;
					            line-height: 200%;
					        }
					   .table {
						    width: 100%;
						    max-width: 100%;
						    margin-bottom: 18px;
						    heigth:20px;
						}

						.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
						    padding: 8px;
						    line-height: 1.42857143;
						    vertical-align: top;
						    border-top: 1px solid #dddddd;
						}

						.table>thead>tr>th {
						    vertical-align: bottom;
						    border-bottom: 2px solid #dddddd;
						}

						.table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>th, .table>caption+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>td, .table>thead:first-child>tr:first-child>td {
						    border-top: 0;
						}

						.table>tbody+tbody {
						    border-top: 2px solid #dddddd;
						}

						.table .table {
						    background-color: #ffffff;
						}

						.table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
						    padding: 5px;
						}

						.table-bordered {
						    border: 1px solid #dddddd;
						}

						.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
						    border: 1px solid #dddddd;
						}

						.table-bordered>thead>tr>th, .table-bordered>thead>tr>td {
						    border-bottom-width: 2px;
						}

						.table-striped>tbody>tr:nth-of-type(odd) {
						    background-color: #f9f9f9;
						}

						.table-hover>tbody>tr:hover {
						    background-color: #f5f5f5;
						}

						table col[class*="col-"] {
						    position: static;
						    float: none;
						    display: table-column;
						}

						table td[class*="col-"], table th[class*="col-"] {
						    position: static;
						    float: none;
						    display: table-cell;
						}

						.table>thead>tr>td.active, .table>tbody>tr>td.active, .table>tfoot>tr>td.active, .table>thead>tr>th.active, .table>tbody>tr>th.active, .table>tfoot>tr>th.active, .table>thead>tr.active>td, .table>tbody>tr.active>td, .table>tfoot>tr.active>td, .table>thead>tr.active>th, .table>tbody>tr.active>th, .table>tfoot>tr.active>th {
						    background-color: #f5f5f5;
						}

						.table-hover>tbody>tr>td.active:hover, .table-hover>tbody>tr>th.active:hover, .table-hover>tbody>tr.active:hover>td, .table-hover>tbody>tr:hover>.active, .table-hover>tbody>tr.active:hover>th {
						    background-color: #e8e8e8;
						}

						.table>thead>tr>td.success, .table>tbody>tr>td.success, .table>tfoot>tr>td.success, .table>thead>tr>th.success, .table>tbody>tr>th.success, .table>tfoot>tr>th.success, .table>thead>tr.success>td, .table>tbody>tr.success>td, .table>tfoot>tr.success>td, .table>thead>tr.success>th, .table>tbody>tr.success>th, .table>tfoot>tr.success>th {
						    background-color: #dff0d8;
						}

						.table-hover>tbody>tr>td.success:hover, .table-hover>tbody>tr>th.success:hover, .table-hover>tbody>tr.success:hover>td, .table-hover>tbody>tr:hover>.success, .table-hover>tbody>tr.success:hover>th {
						    background-color: #d0e9c6;
						}

						.table>thead>tr>td.info, .table>tbody>tr>td.info, .table>tfoot>tr>td.info, .table>thead>tr>th.info, .table>tbody>tr>th.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>tbody>tr.info>td, .table>tfoot>tr.info>td, .table>thead>tr.info>th, .table>tbody>tr.info>th, .table>tfoot>tr.info>th {
						    background-color: #d9edf7;
						}

						.table-hover>tbody>tr>td.info:hover, .table-hover>tbody>tr>th.info:hover, .table-hover>tbody>tr.info:hover>td, .table-hover>tbody>tr:hover>.info, .table-hover>tbody>tr.info:hover>th {
						    background-color: #c4e3f3;
						}

						.table>thead>tr>td.warning, .table>tbody>tr>td.warning, .table>tfoot>tr>td.warning, .table>thead>tr>th.warning, .table>tbody>tr>th.warning, .table>tfoot>tr>th.warning, .table>thead>tr.warning>td, .table>tbody>tr.warning>td, .table>tfoot>tr.warning>td, .table>thead>tr.warning>th, .table>tbody>tr.warning>th, .table>tfoot>tr.warning>th {
						    background-color: #fcf8e3;
						}

						.table-hover>tbody>tr>td.warning:hover, .table-hover>tbody>tr>th.warning:hover, .table-hover>tbody>tr.warning:hover>td, .table-hover>tbody>tr:hover>.warning, .table-hover>tbody>tr.warning:hover>th {
						    background-color: #faf2cc;
						}

						.table>thead>tr>td.danger, .table>tbody>tr>td.danger, .table>tfoot>tr>td.danger, .table>thead>tr>th.danger, .table>tbody>tr>th.danger, .table>tfoot>tr>th.danger, .table>thead>tr.danger>td, .table>tbody>tr.danger>td, .table>tfoot>tr.danger>td, .table>thead>tr.danger>th, .table>tbody>tr.danger>th, .table>tfoot>tr.danger>th {
						    background-color: #f2dede;
						}

						.table-hover>tbody>tr>td.danger:hover, .table-hover>tbody>tr>th.danger:hover, .table-hover>tbody>tr.danger:hover>td, .table-hover>tbody>tr:hover>.danger, .table-hover>tbody>tr.danger:hover>th {
						    background-color: #ebcccc;
						}

						.table-responsive {
						    overflow-x: auto;
						    min-height: 0.01%;
						}
					        .logo{
					            font-size: 14px;
					            padding: 30px 0px;
					            text-align: justify;
					            margin: 0 auto;
					            width:80%;

					        }
					        .orange{
					            color:orange;
					        }
					        .titulo{
					            padding:16px 0px;
					            font-size:18px;
					            font-weight: bold;

					        }
					        .nombre{
					            border-bottom: 1px solid cornsilk;
					            font-size: 24px;
					            font-family: Courier, "Courier new", monospace;
					            font-style: italic;
					        }
					        .descripcion{
					            font-size: 14px;
					            padding: 30px 0px;
					            text-align: justify;
					            margin: 0 auto;
					            width:80%;
					        }
					        .footer {
									margin-top: 120px;
					        }
					    </style>
					</head>
					<body>
					<div class="logo"><img src="logo.png" alt="LOGO" width="100px"><br>Documento Nº <b>' . $rowss->numero_seguridad . '</b><br>F. de Expiración: <b>' . $rowss->expiracion . '</b> </div>
					<div class="titulo">CERTIFICADO DE DEUDAS DE ARRIENDOS</div>
					<div class="descripcion"><a style="color:green;" href="#">Bilder.cl</a> Certifica que Sr(a). <b>' . $fetch->nombres . ' ' . $fetch->apellidos . '</b> RUN Nº <b>' . $rowss->rut_solicitado . '</b>, posee deudas vigentes en el específico proceso de arriendos de propiedades dentro de nuestra base de datos correspondiente a todo el territorio nacional, este documento consta con una vigencia de 30 días desde la fecha de emisión. <br><br><table class="table table-bordered"><tr><th>#</th>
					<th>Dirección</th>
					<th>Región</th>
					<th>Comuna</th>
					<th>Denuncia</th>
					<th>Nº Causa</th>
					</tr>' . $return . '</table>
					<span style="font-size:11px;">Nota: Este documento puede ser validado en la direccion <a href="https://www.bilder.cl/index.php?s=validar">https://www.bilder.cl/index.php?s=validar</a>, revisa mas detalles ingresando el  Nº de documento.</span></p></div><img src="assets/img/743329443593122210217.png" width="220" style="margin-top:-80px; padding:10px;" ><div class="footer"></div><hr>Bilder@2017. Todos los derechos reservados. <br>'.$generatorHTML->getBarcode($rowss->numero_seguridad, $generatorHTML::TYPE_CODE_128).'</body></html>';
                $dompdf->load_html($html);
                $dompdf->render();
                $nombre = md5(microtime());
                $dompdf->stream($nombre . '.pdf');
            }
        } else {
            // CREAR SOLO CERTIFICADO
            if (@$_GET['document']) {
                require_once "dompdf_config.inc.php";
                $dompdf = new DOMPDF();

                $html = '<!DOCTYPE html>
			<html>
			<head lang="en">
			    <meta charset="UTF-8">
			    <title>bilder.cl</title>
			    <style>
			        body{
			            font-family: arial, helvetica, sans-serif;
			            color: #000;
			            background: #fff;
			            padding:40px;
			            text-align: center;
			            line-height: 200%;
			        }
			        .logo{
			            font-size: 14px;
			            padding: 30px 0px;
			            text-align: justify;
			            margin: 0 auto;
			            width:80%;

			        }
			        .orange{
			            color:orange;
			        }
			        .titulo{
			            padding:16px 0px;
			            font-size:18px;
			            font-weight: bold;

			        }
			        .nombre{
			            border-bottom: 1px solid cornsilk;
			            font-size: 24px;
			            font-family: Courier, "Courier new", monospace;
			            font-style: italic;
			        }
			        .descripcion{
			            font-size: 14px;
			            padding: 30px 0px;
			            text-align: justify;
			            margin: 0 auto;
			            width:80%;
			        }
			        .footer {
							margin-top: 120px;
			        }
			    </style>
			</head>
			<body>
			<div class="logo"><img src="logo.png" alt="LOGO" width="100px"><br>Documento Nº <b>' . $rowss->numero_seguridad . '</b><br>F. de Expiración: <b>' . $rowss->expiracion . '</b> <br></div>
			<div class="titulo">CERTIFICADO DE DEUDAS DE ARRIENDOS</div>
			<div class="descripcion"><a style="color:green;" href="#">Bilder.cl</a> Certifica que Sr(a). <b>' . $nombres . ' ' . $apellidos . '</b> RUN Nº <b>' . $rowss->rut_solicitado . '</b>, no posee deudas vigentes en el específico proceso de arriendos de propiedades dentro de nuestra base de datos correspondiente a todo el territorio nacional, este documento consta con una vigencia de 30 días desde la fecha de emisión. <br><br><span style="font-size:11px;">Nota: Este documento puede ser validado en la direccion <a href="https://www.bilder.cl/index.php?s=validar">https://www.bilder.cl/index.php?s=validar</a>, revisa mas detalles ingresando el  Nº de documento.</span></p></div><img src="assets/img/743329443593122210217.png" width="220" style="margin-top:-80px; padding:10px;" ><div class="footer"></div><hr>Bilder@2017. Todos los derechos reservados. <br>'.$generatorHTML->getBarcode($rowss->numero_seguridad, $generatorHTML::TYPE_CODE_128).'</body></html>';
                $dompdf->load_html($html);
                $dompdf->render();
                $nombre = md5(microtime());
                $dompdf->stream($nombre . '.pdf');
            }
        }
    }
}
