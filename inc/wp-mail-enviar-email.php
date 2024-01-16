<?php
// Certifique-se de que este arquivo está no contexto do WordPress
// Você pode precisar incluir o wp-load.php se não estiver usando WordPress como um ponto de entrada
// require_once("caminho-para-o-seu-wp-load.php");

// Obtenha os dados do corpo da solicitação
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Verifique se os dados foram recebidos corretamente
if (!$data) {
  http_response_code(400);
  echo json_encode(['message' => 'Dados inválidos']);
  exit;
}

// Use os dados para enviar e-mail usando wp_mail
$to = 'willianlopes25@outlook.com';  // Substitua pelo endereço de e-mail desejado
$subject = 'Assunto do E-mail';
$message = 'Conteúdo do E-mail: ' . json_encode($data);

$headers = array('Content-Type: text/html; charset=UTF-8');

// Tente enviar o e-mail
if (wp_mail($to, $subject, $message, $headers)) {
  http_response_code(200);
  echo json_encode(['message' => 'E-mail enviado com sucesso']);
} else {
  http_response_code(500);
  echo json_encode(['message' => 'Erro ao enviar e-mail']);
}
