<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * api helper
 */

/**
 * retrieve data customer
 * @param int $customer_nbr
 * @return \SimpleXMLElement
 */
function GetCustomerInfo($customer_nbr) {
    try {
        $soap_client = new SoapClient(SOAP_URL);
        $param = array(
            "CustomerInfoXML" => "<REQUESTINFO>
                    <KEY_NAMEVALUE>
                            <KEY_NAME>CUSTOMERNO</KEY_NAME>
                            <KEY_VALUE>$customer_nbr</KEY_VALUE>
                    </KEY_NAMEVALUE>
                </REQUESTINFO>",
            "ReferenceNo" => random_numbers()
        );
        
        // Setting headernya disini 
        // $auth = array(
        // 'User_id'=>'APIUSER',
        // 'Password'=>'APIUSER@123',
        // 'ExternalPartyName'=> '',
        // );
        $auth = array(
            'User_id' => 'APIWEB',
            'Password' => 'APIWEB@123',
            'ExternalPartyName' => '',
        );
        $header = new SoapHeader('http://tempuri.org/', 'MQUserNameToken', $auth, false);
        $soap_client->__setSoapHeaders($header);

        // Hit API disini
        $result = $soap_client->GetCustomerInfo($param);
        
        $sxml = new SimpleXMLElement($result->GetCustomerInfoResult);

        return $sxml;
    } catch (SoapFault $exception) {
        return $exception->getMessage();
    }
}

/**
 * convert from xml data to array
 * @param object $xmlObject
 * @param array $out
 * @return array
 */
function xml2array($xmlObject, $out = array()) {
    foreach ((array) $xmlObject as $index => $node)
        $out[$index] = ( is_object($node) ) ? xml2array($node) : $node;
    return $out;
}

/**
 * make payment to api
 * @param string $customer_nbr
 * @param string $amount
 * @param string $User_id
 * @param string $Password
 * @param string $ExternalPartyName
 * @return type
 */
function MakePaymentsV1($customer_nbr, $amount, $User_id, $Password, $ExternalPartyName) {
    try {
        $soap_client = new SoapClient(SOAP_URL);

        // Masukan parameter sesuai dengan field APInya disini
        $param = array(
            "MakePaymentXML" =>
            "<REQUESTINFO>
					<KEY_NAMEVALUE>
					<KEY_NAME>CUSTOMERNO</KEY_NAME>
					<KEY_VALUE>" . $customer_nbr . "</KEY_VALUE>
					</KEY_NAMEVALUE>
					<PAYMENTINFO>
					<AMOUNT>" . $amount . "</AMOUNT>
					<PAYMODE>CA</PAYMODE>
					<RECEIPTNO>1978254</RECEIPTNO>
					<REMARKS>Pembelian Voucher by " . $ExternalPartyName . "</REMARKS>
					</PAYMENTINFO>
					</REQUESTINFO>",
            "ReferenceNo" => random_number()
        );

        // Setting headernya disini
        $auth = array(
            'User_id' => $User_id,
            'Password' => $Password,
            'ExternalPartyName' => $ExternalPartyName,
        );
        $header = new SoapHeader('http://tempuri.org/', 'MQUserNameToken', $auth, false);
        $soap_client->__setSoapHeaders($header);

        // Hit API disini
        $result = $soap_client->MakePayment($param);

        // Parse Data XML
        $sxml = new SimpleXMLElement($result->MakePaymentResult);
        // $sql = "insert into api_log (method,reference_no,external_party_name,request_xml,key_name,value_name,response,error,created_by,created_date)
        // value ('MakePayment','".$reference_no."','".$ExternalPartyName."','".$param['MakePaymentXML']."','CUSTOMERNO','".$customer_nbr."','".$sxml->STATUS->MESSAGE."','".$sxml->STATUS->ERRORNO."','".$User_id."',NOW())";
        // mysql_query($sql);
        return $sxml->STATUS->MESSAGE;
        // print_r($sxml);
    } catch (SoapFault $exception) {
        return $exception->getMessage();
    }
}

function hex2bi22n($hexSource) {
    $bin = '';
    for ($i = 0; $i < strlen($hexSource); $i = $i + 2) {
        $bin .= chr(hexdec(substr($hexSource, $i, 2)));
    }
    return $bin;
}

function E2Pay_signature($source) {
    return base64_encode(hex2bi22n(sha1($source)));
}

/**
 * MQ API
 * added by fadilah ajiq surya
 * at 10 August 2015, 1:28 PM, BSP
 */

function AddContract($param) {
    try {

        $soap_client = new SoapClient('http://139.0.22.187/BIGTVTESTWEBSERVICE/service.asmx?wsdl');

    
        $param = array(
            "AddContractXML" => "
            <REQUESTINFO>
                <KEY_NAMEVALUE>

                 <KEY_NAME>CUSTOMERNO</KEY_NAME>
                 <KEY_VALUE>".$param['customer_no']."</KEY_VALUE>

                </KEY_NAMEVALUE>
               <CONTRACTINFO>
                <CONTRACTNO></CONTRACTNO>
                <ORDERDATE>".$param['order_date']."</ORDERDATE>
                <EFFECTIVEDATE>".$param['effective_date']."</EFFECTIVEDATE>
                <ISBULK></ISBULK>
                <BILLFREQUENCY></BILLFREQUENCY>
                <SALESMANCODE></SALESMANCODE>
                <OUTLETS></OUTLETS>
                <NOTES></NOTES>
                <STATUS></STATUS>
                <COUPON></COUPON>
                <PLANINFO>
                 <PLANCODE>".$param['plancode']."</PLANCODE>
                 <SERVICEGROUPINFO>
                  <SERVICEGROUPCODE>".$param['service_group_code']."</SERVICEGROUPCODE>
                 </SERVICEGROUPINFO>
                </PLANINFO>
               </CONTRACTINFO>
              </REQUESTINFO>",
            "ReferenceNo" => random_number()
        );
        
        
        $auth = array(
            'User_id' => 'APIWEB',
            'Password' => 'APIWEB@123',
            'ExternalPartyName' => '',
        );
        $header = new SoapHeader('http://tempuri.org/', 'MQUserNameToken', $auth, false);
        $soap_client->__setSoapHeaders($header);

        // Hit API disini
        //$sxml = new SimpleXMLElement($result->GetCustomerInfoResult);
        $result = $soap_client->AddContract($param);
        
        $sxml = new SimpleXMLElement($result->AddContractResult);


        return xml2array($sxml);
    } catch (SoapFault $exception) {
        return $exception->getMessage();
    }
}

function DisconnectContract($data){
    try {
        $soap_client = new SoapClient('http://139.0.22.187/BIGTVTESTWEBSERVICE/service.asmx?wsdl');
        $param = array(
            "DisconnectContractXML" => "
            <REQUESTINFO>
            <KEY_NAMEVALUE>
             <KEY_NAME>CONTRACTNO</KEY_NAME>
             <KEY_VALUE>".$data['contractno']."</KEY_VALUE>
            </KEY_NAMEVALUE>
            <DISCONNECTIONINFO>
             <DISCONNECTIONDATE>".$data['disconnectiondate']."</DISCONNECTIONDATE>
             <REASON>EXPIRED</REASON>
             <REMARKS>DISCONNECT</REMARKS>
            </DISCONNECTIONINFO>
           </REQUESTINFO>",
            "ReferenceNo" => random_number()
        );
        
        
        $auth = array(
            'User_id' => 'APIUSER',
            'Password' => 'APIWEB@BIGTV',
            'ExternalPartyName' => ''
        );
        $header = new SoapHeader('http://tempuri.org/', 'MQUserNameToken', $auth, false);
        $soap_client->__setSoapHeaders($header);

        // Hit API disini
        //$sxml = new SimpleXMLElement($result->GetCustomerInfoResult);
        $result = $soap_client->DisconnectContract($param);
        
        $sxml = new SimpleXMLElement($result->DisconnectContractResult);


        return xml2array($sxml);
    } catch (SoapFault $exception) {
        return $exception->getMessage();
    }
}
function DisconnectContractTest($data){
    try {
        $soap_client = new SoapClient('http://139.0.22.187/BIGTVTESTWEBSERVICE/service.asmx?wsdl');
        $param = array(
            "DisconnectContractXML" => "
            <REQUESTINFO>
            <KEY_NAMEVALUE>
             <KEY_NAME>CONTRACTNO</KEY_NAME>
             <KEY_VALUE>1323443</KEY_VALUE>
            </KEY_NAMEVALUE>
            <DISCONNECTIONINFO>
             <DISCONNECTIONDATE>14-08-2015</DISCONNECTIONDATE>
             <REASON>EXPIRED</REASON>
             <REMARKS>DISCONNECT</REMARKS>
            </DISCONNECTIONINFO>
           </REQUESTINFO>",
            "ReferenceNo" => random_number()
        );
        
        
        $auth = array(
            'User_id' => 'APIUSER',
            'Password' => 'APIWEB@BIGTV',
            'ExternalPartyName' => ''
        );
        $header = new SoapHeader('http://tempuri.org/', 'MQUserNameToken', $auth, false);
        $soap_client->__setSoapHeaders($header);

        // Hit API disini
        //$sxml = new SimpleXMLElement($result->GetCustomerInfoResult);
        $result = $soap_client->DisconnectContract($param);
        
        $sxml = new SimpleXMLElement($result->DisconnectContractResult);
        print_r(xml2array($sxml));
        die();
        return xml2array($sxml);
    } catch (SoapFault $exception) {
        return $exception->getMessage();
    }
}