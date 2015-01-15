<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$loader = require __DIR__.'/../vendor/autoload.php';

$d = new \Karser\Core\Dispatcher();

$loader = new Twig_Loader_Filesystem(__DIR__ .'/../app/views');
$twig = new Twig_Environment($loader);

$d->addClosure('/', function($r) use ($twig){
    /** @var  \Karser\Core\Request $r */
    if ($r->getMethod() === 'POST' && $r->hasFile('log')) {
        $log = md5(time());
        if (!$r->moveFile('log', sys_get_temp_dir().'/'.$log)) {
            throw new \Exception('uploading error');
        }
        return new \Karser\Core\ResponseRedirect('/show?log='.$log);
    }
    return new \Karser\Core\Response($twig->render('upload.html.twig', ['name' => 'log']));
});

$d->addClosure('/show', function($r) use ($twig){
    /** @var  \Karser\Core\Request $r */
    if (!$r->hasParam('log')) {
        throw new \Exception('Please specify log parameter');
    }
    $h = new \Karser\Business\LogHandler();
    $h->load(sys_get_temp_dir().'/'.$r->getParam('log'));
    return new \Karser\Core\Response($twig->render('stat.html.twig', ['stat' => $h->getStats()]));
});
$d->run();