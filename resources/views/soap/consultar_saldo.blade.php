<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope
    xmlns:soap="http://www.w3.org/2003/05/soap-envelope/"
    soap:encodingStyle="http://www.w3.org/2003/05/soap-encoding">
    <soap:Body>
        <Documento>{{$data['Documento']}}</Documento>
        <Celular>{{$data['Celular']}}</Celular>
    </soap:Body>
</soap:Envelope>
