<?php
/**
 * GETNET
 *
 * Cliente para o Web Service da GETNET.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença MIT
 * 
 * Baseado na documentação técnica - versão 1.2 de 05/2014
 *
 * @category   Classes
 * @package    Cliente
 * @subpackage GETNET
 * @copyright  Bruno Paz  <brunopaz@azpay.com.br> (c) 2015
 * @license    MIT
 */
class Getnet
{
    /*
    * Usuário de acesso
    */
    private $_username;
    /*
    * Senha de acesso
    */
    private $_password;
    /*
    * Código de EC cadastrado na GETNET
    */
    private $_merchantID;
    /*
    * O TerminalID é composto por um campo Alfanumérico de 8 posições e 2 dígitos adicionais que identificam o produto e a Bandeira.
    */
    private $_terminalID;
    /*
    * ID da transação, que deverá ser gerado pela Loja Virtual. Este deve ser único por transação.
    */
    private $_merchantTrackID;
    /*
    * Valor da transação. O formato deve ser o valor inteiro com ponto e 2 casas decimais. Ex.: "10000.00"
    */
    private $_amount;
    /*
    * Código da moeda. Segue o padrão ISO 4217. O valor padrão é 986 – Real.
    */
    private $_currencycode;
    /*
    * Identifica o tipo de pagamento a ser efetuado:SGL - À vista | ACQ - Parcelado Lojista | ISS - Parcelado Emissor
    */
    private $_instType;
    /*
    * Para transações parceladas indica o número de parcelas. Para transações à vista não deve ser preenchido.
    */
    private $_instNum;
    /*
    * Número do cartão do portador que será utilizado na transação.
    */
    private $_number;
    /*
    * O código de segurança, encontrado no verso do cartão do portador.
    */
    private $_cvv2 = NULL;
    /*
    * Mês de expiração do cartão.
    */
    private $_expiryMonth = NULL;
    /*
    * Ano de expiração do cartão.
    */
    private $_expiryYear = NULL;
    /*
    * Nome do portador impresso no cartão.
    */
    private $_holderName = NULL;
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    private $_udf1 = NULL;
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    private $_udf2 = NULL;
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    private $_udf3 = NULL;
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    private $_udf4 = NULL;
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    private $_udf5 = NULL;
    /*
    * O MCC permite que o Estabelecimento Comercial venda diversos tipos de produtos/serviços de segmentos diferentes, possibilitando a identificação do correto ramo de atividade para cada transação efetuada.Dessa forma uma loja pode identificar ao Adquirente o MCC de cada compra, seja uma compra de eletroeletrônico, seja uma compra de livros, etc., facilitando controles como perfil de fraude e comportamento de compras.
    */
    private $_tranMCC = NULL;
    /*
    * O Soft-Descriptor possibilita que sejam enviadas nas transações a informação de identificação que deseja que apareça no campo nome fantasia. Como exemplo, pode-se ter o nome do Estabelecimento Comercial que está no cadastro da Adquirência mais o nome do intermediador que está recebendo o pagamento.
    */
    private $_softDescriptor = NULL;

    private $_errors;
    private $_urlRetorno;
    private $_ambiente = '';
    private $_tid;
    private $_transactionID;
    /*
    * Usuário de acesso
    */
    public function setUsername($username){
        return $this->_username = $username;
    }
    /*
    * Senha de acesso
    */
    public function setPassword($password){
        return $this->_password = $password;
    }
    /*
    * Código de EC cadastrado na GETNET
    */
    public function setMerchantID($merchantID){
        return $this->_merchantID = $merchantID;
    }
    /*
    * O TerminalID é composto por um campo Alfanumérico de 8 posições e 2 dígitos adicionais que identificam o produto e a Bandeira.
    */
    public function setTerminalID($terminalID){
        return $this->_terminalID = $terminalID;
    }
    /*
    * ID da transação, que deverá ser gerado pela Loja Virtual. Este deve ser único por transação.
    */
    public function setMerchantTrackID($merchantTrackID){
        return $this->_merchantTrackID = $merchantTrackID;
    }
    /*
    * Valor da transação. O formato deve ser o valor inteiro com ponto e 2 casas decimais. Ex.: "10000.00"
    */
    public function setAmount($amount){
        return $this->_amount = $amount;
    }
    /*
    * Código da moeda. Segue o padrão ISO 4217. O valor padrão é 986 – Real.
    */
    public function setCurrencycode($currencycode){
        return $this->_currencycode = $currencycode;
    }
    /*
    * Identifica o tipo de pagamento a ser efetuado:SGL - À vista | ACQ - Parcelado Lojista | ISS - Parcelado Emissor
    */
    public function setInstType($instType){
        return $this->_instType = $instType;
    }
    /*
    * Para transações parceladas indica o número de parcelas. Para transações à vista não deve ser preenchido.
    */
    public function setInstNum($instNum){
        return $this->_instNum = $instNum;
    }
    /*
    * Número do cartão do portador que será utilizado na transação.
    */
    public function setNumber($number){
        return $this->_number = $number;
    }
    /*
    * O código de segurança, encontrado no verso do cartão do portador.
    */
    public function setCvv2($cvv2){
        return $this->_cvv2 = $cvv2;
    }
    /*
    * Mês de expiração do cartão.
    */
    public function setExpiryMonth($expiryMonth){
        return $this->_expiryMonth = $expiryMonth;
    }
    /*
    * Ano de expiração do cartão.
    */
    public function setExpiryYear($expiryYear){
        return $this->_expiryYear = $expiryYear;
    }
    /*
    * Nome do portador impresso no cartão.
    */
    public function setHolderName($holderName){
        return $this->_holderName = $holderName;
    }
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    public function setUdf1($udf1){
        return $this->_udf1 = $udf1;
    }
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    public function setUdf2($udf2){
        return $this->_udf2 = $udf2;
    }
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    public function setUdf3($udf3){
        return $this->_udf3 = $udf3;
    }
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    public function setUdf4($udf4){
        return $this->_udf4 = $udf4;
    }
    /*
    * Campos de apoio e alternativos na transação, qualquer conteúdo pode ser informado e recuperado nestas variáveis.
    */
    public function setUdf5($udf5){
        return $this->_udf5 = $udf5;
    }
    /*
    * O MCC permite que o Estabelecimento Comercial venda diversos tipos de produtos/serviços de segmentos diferentes, possibilitando a identificação do correto ramo de atividade para cada transação efetuada.Dessa forma uma loja pode identificar ao Adquirente o MCC de cada compra, seja uma compra de eletroeletrônico, seja uma compra de livros, etc., facilitando controles como perfil de fraude e comportamento de compras.
    */
    public function setTranMCC($tranMCC){
        return $this->_tranMCC = $tranMCC;
    }
    /*
    * O Soft-Descriptor possibilita que sejam enviadas nas transações a informação de identificação que deseja que apareça no campo nome fantasia. Como exemplo, pode-se ter o nome do Estabelecimento Comercial que está no cadastro da Adquirência mais o nome do intermediador que está recebendo o pagamento.
    */
    public function setSoftDescriptor($softDescriptor){
        return $this->_softDescriptor = $softDescriptor;
    }
    /**
     * Retorna o nome do classe
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return __CLASS__;
    }
    /**
     * Seta os erros
     *
     * @access public
     * @return string
     */
    public function setError($code)
    {
        $this->_errors =  $code;
    }
    public function getError()
    {
        if($this->_errors){
            $error = array();
            $error['codigo']  = $this->_errors;
            $error['mensagem'] = ' - validado antes de enviar para GETNET';
            return self::array2xml($error);
        }
    }
    public function isError()
    {
        if(!empty($this->_errors))
            return true;
        else return false;
    }
    /**
     * Erro para chamadas a métodos inválidos.
     *
     * @access public
     * @param  string $nome
     * @param  mixed  $argumentos
     * @return Exception
     */
    public function __call($nome, $argumentos)
    {
       throw new Exception("Método inexistente: {$nome}.");
    }
    /**
     * Retorna a URL de Retorno setada para a transação
     *
     * @acess public
     * @return string
     */
    public function getUrlRetorno()
    {
        return $this->_urlRetorno;
    }
    /**
    * Define a URL de Retorno da transação
    *
    * @access public
    * @param  string $_url
    */
    public function setUrlRetorno($_url = null)
    {
        $this->_urlRetorno = substr($_url, 0, 1024);
    }
    /**
     * Configura o valor do TID
     *
     * @access public
     * @return string
     */
    public function getTid()
    {
        return $this->_tid;
    }
    /**
     * Configura o TID
     *
     * @access public
     * @param  string $_tid
     * @return Getnet
     */
    public function setTid($_tid)
    {
        $this->_tid = $_tid;
        if(!$_tid) $this->setError('016');
    }
    /**
     * Seta o último XML configurado
     *
     * @access public
     * @return string
     */
    public function setXmlRetorno($_xml_retorno)
    {
          $this->_xml_retorno = $_xml_retorno;
    }
    /**
     * Retorna o último XML configurado
     *
     * @access public
     * @return string
     */
    public function getXmlRetorno()
    {
        return $this->_xml_retorno;
    }
    /**
     * Retorna o último XML configurado
     *
     * @access public
     * @return string
     */
    public function getXml()
    {
        return $this->_xml;
    }
    /**
     * Seta o XML da chamada ou retorno
     *
     * @access public
     * @param  string $_xml
     * @return Getnet
     */
    public function setXml($_xml)
    {
        $this->_xml = $_xml;
    }
    /**
    * Envia a chamada para o Web Service da Getnet
    * @access private
    * @param string $action Endpoint do webservice_xml_retorno
    * @return string  XML de resposta da transação solicitada
    */
    private function sendXML($action)
    {
        if ($this->_ambiente == 'admin') {
            $url = 'https://cgws-hti.getnet.com.br:4443/eCommerceWS/1.1/AdministrationService?wsdl';
        }else{
            $url = 'https://cgws-hti.getnet.com.br:4443/eCommerceWS/1.1/CommerceService?wsdl';
        }
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                              '.str_replace('<?xml version="1.0"?>','',$this->_xml).'
                              </soap:Body>
                            </soap:Envelope>';
       $headers = array(
                            "Content-type: text/xml;charset=\"utf-8\"",
                            "Accept: text/xml",
                            "Cache-Control: no-cache",
                            "Pragma: no-cache",
                            "SOAPAction: {http://br.com.getnet.ecommerce.ws.service/}".$action,
                            "Content-length: ".strlen($xml_post_string),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_username.":".$this->_password); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $this->setXmlRetorno($response);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status <> '200' || !$this->_xml_retorno){
            $this->setError('100');
            return false;
        }
        return $this->_xml_retorno;
    }
    /**
     * XMLResult2Object
     * Converte a resposta da GETNET de xml para objeto
     * @return  objeto
     */
    public function XMLResult2Object()
    {
        if(strlen($this->_xml_retorno) > 0){
            $xml = simplexml_load_string($this->_xml_retorno,NULL,NULL,"http://schemas.xmlsoap.org/soap/envelope/");
            $xml->registerXPathNamespace('S', 'http://schemas.xmlsoap.org/soap/envelope/');
            $xml->registerXPathNamespace('ns0', 'http://br.com.getnet.ecommerce.ws.service');
            $xpath = $xml->xpath('//result');
            return $xpath;
        }else{
            return false;
        }
    }
    /**
    * PurchaseService
    * Executa, em uma única chamada, uma Autorização seguida de uma Confirmação (Captura), caso a autorização tenha sido aprovada.
    */
    public function PurchaseService()
    {
        $_xml = '<purchaseService xmlns="http://br.com.getnet.ecommerce.ws.service/"></purchaseService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $purchases = $arg->addChild('purchases','');
            $purchase = $purchases->addChild('purchase','');
                if(!is_null($this->_terminalID) )$purchase->addChild('terminalID',$this->_terminalID);
                if(!is_null($this->_merchantTrackID) )$purchase->addChild('merchantTrackID',$this->_merchantTrackID);
                if(!is_null($this->_amount) )$purchase->addChild('amount',$this->_amount);
                if(!is_null($this->_currencycode) )$purchase->addChild('currencycode',$this->_currencycode);
                if(!is_null($this->_instType) )$purchase->addChild('instType',$this->_instType);
                if(!is_null($this->_instNum) )$purchase->addChild('instNum',$this->_instNum);
                $card = $purchase->addChild('card','');
                   if(!is_null($this->_number) )$card->addChild('number',$this->_number);
                   if(!is_null($this->_cvv2) )$card->addChild('cvv2',$this->_cvv2);
                   if(!is_null($this->_expiryMonth) )$card->addChild('expiryMonth',$this->_expiryMonth);
                   if(!is_null($this->_expiryYear) )$card->addChild('expiryYear',$this->_expiryYear);
                   if(!is_null($this->_holderName) )$card->addChild('holderName',$this->_holderName);
                $userDefinedField = $purchase->addChild('userDefinedField','');
                    if(!is_null($this->_udf1) )$userDefinedField->addChild('udf1',$this->_udf1);
                    if(!is_null($this->_udf2) )$userDefinedField->addChild('udf2',$this->_udf2);
                    if(!is_null($this->_udf3) )$userDefinedField->addChild('udf3',$this->_udf3);
                    if(!is_null($this->_udf4) )$userDefinedField->addChild('udf4',$this->_udf4);
                    if(!is_null($this->_udf5) )$userDefinedField->addChild('udf5',$this->_udf5);
                if(!is_null($this->_tranMCC) )$purchase->addChild('tranMCC',$this->_tranMCC);
                if(!is_null($this->_softDescriptor) )$purchase->addChild('softDescriptor',$this->_softDescriptor);

        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('purchaseService');
    }
    /**
    * AuthorizationService
    * Executa uma Autorização, sem a Confirmação (Captura).
    * A transação, se autorizada, se mantêm pendente de Confirmação.
    */
    public function AuthorizationService()
    {
        $_xml = '<authorizationService xmlns="http://br.com.getnet.ecommerce.ws.service/"></authorizationService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $authorizations = $arg->addChild('authorizations','');
            $authorization = $authorizations->addChild('authorization','');
                $authorization->addChild('terminalID',$this->_terminalID);
                $authorization->addChild('merchantTrackID',$this->_merchantTrackID);
                $authorization->addChild('amount',$this->_amount);
                $authorization->addChild('currencycode',$this->_currencycode);
                $authorization->addChild('instType',$this->_instType);
                $authorization->addChild('instNum',$this->_instNum);
                $card = $authorization->addChild('card','');
                   $card->addChild('number',$this->_number);
                   $card->addChild('cvv2',$this->_cvv2);
                   $card->addChild('expiryMonth',$this->_expiryMonth);
                   $card->addChild('expiryYear',$this->_expiryYear);
                   $card->addChild('holderName',$this->_holderName);
                $userDefinedField = $authorization->addChild('userDefinedField','');
                    $userDefinedField->addChild('udf1',$this->_udf1);
                    $userDefinedField->addChild('udf2',$this->_udf2);
                    $userDefinedField->addChild('udf3',$this->_udf3);
                    $userDefinedField->addChild('udf4',$this->_udf4);
                    $userDefinedField->addChild('udf5',$this->_udf5);
                $authorization->addChild('tranMCC',$this->_tranMCC);
                $authorization->addChild('softDescriptor',$this->_softDescriptor);

        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('authorizationService');
    }
    /**
    * CaptureService
    * Executa a Captura da Autorização (Confirmação).
    * O valor da transação pode ser maior (desde que não ultrapasse 15% do valor original), igual ou menor (sem limitação).
    */
    public function CaptureService()
    {
        $_xml = '<captureService xmlns="http://br.com.getnet.ecommerce.ws.service/"></captureService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $capture = $arg->addChild('capture','');
            $capture2 = $capture->addChild('capture','');
                $capture2->addChild('terminalID',$this->_terminalID);
                $capture2->addChild('merchantTrackID',$this->_merchantTrackID);
                $capture2->addChild('amount',$this->_amount);
                $capture2->addChild('currencycode',$this->_currencycode);
                $capture2->addChild('instType',$this->_instType);
                $capture2->addChild('instNum',$this->_instNum);
                $capture2->addChild('transactionID',$this->_transactionID);
        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('captureService');
    }
   /**
    * CancellationService
    * Executa o estorno de uma transação Autorizada ou Confirmada.
    * Somente é possível estornar uma transação confirmada (Capturada) no dia corrente.
    */
    public function CancellationService()
    {
        $_xml = '<br:cancellationService></cancellationService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $cancel = $arg->addChild('cancel','');
            $cancel2 = $cancel->addChild('cancel','');
                $cancel2->addChild('terminalID',$this->_terminalID);
                $cancel2->addChild('transactionID',$this->_transactionID);
                $cancel2->addChild('merchantTrackID',$this->_merchantTrackID);
                $cancel2->addChild('amount',$this->_amount);
                $cancel2->addChild('currencycode',$this->_currencycode);
        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('cancellationService');
    }
    /**
    * QueryDataService
    * Executa uma operação de Consulta da transação.
    */
    public function QueryDataService()
    {
        $_xml = '<queryDataService xmlns="http://br.com.getnet.ecommerce.ws.service/"></queryDataService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $query = $arg->addChild('query','');
            $query2 = $query->addChild('query','');
                $cquery2->addChild('terminalID',$this->_terminalID);
                $cquery2->addChild('merchantTrackID',$this->_merchantTrackID);
        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('queryDataService');
    }
   /**
    * CardVerificationService
    * O objetivo da transação de verificação de cartão de crédito é verificar se o cartão de crédito informado pelo portador é um cartão válido.
    * Entende-se como um cartão crédito válido, um cartão que não está cancelado, bloqueado ou com restrições.Este método é muito utilizado para 
    * diminuir o risco e o trabalho operacional de revisão de pedidos/solicitações de compras.
    */
    public function CardVerificationService()
    {
        $_xml = '<br:cardVerificationService></cardVerificationService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $authentication = $arg->addChild('authentication','');
            $authentication->addChild('username', $this->_username);
            $authentication->addChild('password', $this->_password);
            $authentication->addChild('merchantID', $this->_merchantID);
        $cardVerification = $arg->addChild('cardVerification','');
            $cardVerification2 = $authorizations->addChild('cardVerification','');
                $cardVerification2->addChild('terminalID',$this->_terminalID);
                $cardVerification2->addChild('merchantTrackID',$this->_merchantTrackID);
                $cardVerification2->addChild('currencycode',$this->_currencycode);
                $card = $cardVerification2->addChild('card','');
                   $card->addChild('number',$this->_number);
                   $card->addChild('cvv2',$this->_cvv2);
                   $card->addChild('expiryMonth',$this->_expiryMonth);
                   $card->addChild('expiryYear',$this->_expiryYear);
                   $card->addChild('holderName',$this->_holderName);
        $this->_xml = htmlspecialchars_decode($xml->asXML());
        return $this->sendXML('cardVerificationService');
    }
    /**
    * ChangeAuthenticationService
    * Por segurança ao cadastrar uma nova Loja Virtual, a GetNet obriga a Loja Virtual a alterar seu código de acesso antes de iniciar o fluxo transacional.
    */
    public function ChangeAuthenticationService($newPassword)
    {
        $_xml = '<changeAuthenticationService xmlns="http://br.com.getnet.ecommerce.ws.service/"></changeAuthenticationService>';
        $xml = new SimpleXMLElement($_xml);
        $arg = $xml->addChild('arg0','');
        $arg->addAttribute('xmlns', '');
        $arg->addChild('username',$this->_username);
        $arg->addChild('merchantID',$this->_merchantID);
        $arg->addChild('currentPassword',$this->_password);
        $arg->addChild('newPassword',$newPassword);
        $this->_xml = htmlspecialchars_decode($xml->asXML());
        $this->_ambiente = 'admin';
        return $this->sendXML('changeAuthenticationService');
    }
}
