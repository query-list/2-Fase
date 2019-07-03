<?php
	require 'vendor/autoload.php';
	require 'controller/controllerUsuarios.php';
	require 'controller/controllerTelefones.php';
	
	$app = new \Slim\App();
	
	$app->get('/', function ($request, $response, $args) {
		return $response->withStatus(302)->withRedirect('index.html');
	});
	
	$app->get('/admin', function ($request, $response, $args) {
		session_start();
		if(!(empty($_SESSION['usuario']))){
			return $response->withStatus(302)->withRedirect('view/usuarios/admin.html');	 
		}
		else{
		  return $response->withStatus(302)->withRedirect('view/usuarios/login.html');
		}
	});
	
	$app->post('/login', function ($request, $response, $args) {
		   ControllerUsuarios::login($request->getParsedBodyParam('usuario'), $request->getParsedBodyParam('senha'));
		});
		
	$app->get('/logout', function ($request, $response, $args) {
		   ControllerUsuarios::logout();
		   return $response->withStatus(302)->withRedirect('/admin');
		});
		
	$app->post('/usuario/cadastro', function ($request, $response, $args) {
		   session_start();
		   if(empty($_SESSION['usuario']))
		     exit;
		   ControllerUsuarios::cadastrar($request->getParsedBodyParam('nome'), $request->getParsedBodyParam('usuario'), 
		     $request->getParsedBodyParam('email'), $request->getParsedBodyParam('senha'), $request->getParsedBodyParam('id'));
	});
		
	$app->get('/usuarios/listar', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerUsuarios::listar();
	});
	
	$app->get('/usuarios/{id}', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
	    ControllerUsuarios::busca($args['id']);
		//ControllerUsuarios::deletar($args['id']);
	});
	
	$app->delete('/usuarios/{id}', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerUsuarios::deletar($args['id']);
	});
	
	
	$app->put('/usuarios/{id}', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerUsuarios::atualiza($request->getParsedBodyParam('nome'), $request->getParsedBodyParam('usuario'), $request->getParsedBodyParam('email'),
		  $request->getParsedBodyParam('senha'), $args['id']);
	});	
	
    $app->get('/telefones/cidades', function ($request, $response, $args) {
		ControllerTelefones::listarCidades();
	});
	
	$app->get('/telefones/cidades/{uf}', function ($request, $response, $args) {
		ControllerTelefones::listarCidadesUF($args['uf']);
	});

	$app->get('/telefones/categorias', function ($request, $response, $args) {
		ControllerTelefones::listarCategorias();
	});
	
	$app->post('/telefones', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerTelefones::cadastrarTelefone($request->getParsedBodyParam('nome'),$request->getParsedBodyParam('numero'),
     		$request->getParsedBodyParam('categoria'), $request->getParsedBodyParam('cidade'), trim($request->getParsedBodyParam('palavras')));
	});
	
	$app->put('/telefones/{id}', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerTelefones::atualizarTelefone($request->getParsedBodyParam('nome'),$request->getParsedBodyParam('numero'),
     		$request->getParsedBodyParam('categoria'), $request->getParsedBodyParam('cidade'), trim($request->getParsedBodyParam('palavras')),
			$args['id']);	  
	});
	
	$app->get('/telefones', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerTelefones::listar();
	});
	
	$app->get('/telefones/{id}', function ($request, $response, $args) {
		ControllerTelefones::buscaTelefoneId($args['id']);
	});
	
	
	$app->post('/telefone/cidade/{id}', function ($request, $response, $args) {
		ControllerTelefones::buscaTelefoneCidade($args['id']);
	});	
	
	$app->delete('/telefones/{id}', function ($request, $response, $args) {
		session_start();
		if(empty($_SESSION['usuario']))
		  exit;
		ControllerTelefones::deletar($args['id']);
	});
	
	
	$app->run();
?>