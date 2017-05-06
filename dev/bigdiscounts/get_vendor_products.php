<?php

function get_vendor_products($email) {

    $html = "";

    include '../dev/bigdiscounts/connect.php';
    include '../dev/credentials.php';

    $sql = "SELECT * from retailers where email = '$email'";

    $result = $conn->query($sql);

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $pids = explode(',', $row["products"]);

        foreach ($pids as $pid) {
            // Suppress warnings
            error_reporting(0);

            // The region you are interested in
            $endpoint = "webservices.amazon.in";

            $uri = "/onca/xml";

            $params = array(
                "Service" => "AWSECommerceService",
                "Operation" => "ItemLookup",
                "AWSAccessKeyId" => "AKIAJDFOBDG56PTMTDDQ",
                "AssociateTag" => "rohananand-21",
                "ItemId" => $pid,
                "IdType" => "ASIN",
                "ResponseGroup" => "Images,ItemAttributes,Offers"
            );

            // Set current timestamp if not set
            if (!isset($params["Timestamp"])) {
                $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
            }

            // Sort the parameters by key
            ksort($params);

            $pairs = array();

            foreach ($params as $key => $value) {
                array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
            }

            // Generate the canonical query
            $canonical_query_string = join("&", $pairs);

            // Generate the string to be signed
            $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

            // Generate the signature required by the Product Advertising API
            $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

            // Generate the signed URL
            $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

            $response = file_get_contents($request_url);
            $parsed_xml = simplexml_load_string($response);

            // Verify Request
            foreach($parsed_xml->OperationRequest->Errors->Error as $error){
                echo "Error code: " . $error->Code . "\r\n";
                echo $error->Message . "\r\n";
                echo "\r\n";
            }

            // echo $parsed_xml->OperationRequest->RequestId;

            $current = $parsed_xml->Items->Item;

            foreach($current->ItemAttributes->Feature as $itemFeature) {
                $attr .= '<li class="list-group-item">' . $itemFeature . '</li>';
            }

            $html .=    '<div class="col-md-4">' .
                            '<div class="card">' .
                                '<div class="img-container">' .
                                    '<img src="' . $current->LargeImage->URL . '" width="304" height="236">' .
                                '</div>' .
                                '<div class="card-content">' .
                                    '<h4 class="product-title-short"><a href="' . $current->DetailPageURL . '">' . $current->ItemAttributes->Title . '</a></h4>' .
                                    '<h5>' . 'Lowest Price : <b>' . $current->OfferSummary->LowestNewPrice->FormattedPrice . '</b></h5>' .
                                '</div>' .
                                '<div class="card-controls">' .
                                    '<form action="" method="POST">' .
                                        '<input type="hidden" name="product_id" value="' . $current->ASIN . '">' .
                                        '<button class="btn btn-primary" type="submit" name="compare-button">Add to Stock</button>' .
                                        '<a class="btn btn-default" href="show-details.php?pid='.$current->ASIN.'" name="lookup-button">See Details</a>'.
                                    '</form>' .
                                '</div>' .
                            '</div>' .
                        '</div>';



        }
    }
    return $html;
}
?>
