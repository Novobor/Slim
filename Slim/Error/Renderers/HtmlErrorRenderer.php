<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim\Error\Renderers;

use Slim\Error\AbstractErrorRenderer;
use Exception;

/**
 * Default Slim application HTML Error Renderer
 */
class HtmlErrorRenderer extends AbstractErrorRenderer
{
    /**
     * @param \Exception|\Throwable $exception
     * @param bool $displayErrorDetails
     * @return string
     */
    public function render($exception, $displayErrorDetails)
    {
        $title = 'Slim Application Error';

        if ($displayErrorDetails) {
            $html = '<p>The application could not run because of the following error:</p>';
            $html .= '<h2>Details</h2>';
            $html .= $this->renderExceptionFragment($exception);
        } else {
            $html = '<p>A website error has occurred. Sorry for the temporary inconvenience.</p>';
        }

        return $this->renderHtmlBody($title, $html);
    }

    /**
     * @param string $title
     * @param string $html
     * @return string
     */
    public function renderHtmlBody($title = '', $html = '')
    {
        return sprintf(
            "<html>" .
            "   <head>" .
            "       <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>" .
            "       <title>%s</title>" .
            "       <style>" .
            "           body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif}" .
            "           h1{margin:0;font-size:48px;font-weight:normal;line-height:48px}" .
            "           strong{display:inline-block;width:65px}" .
            "       </style>" .
            "   </head>" .
            "   <body>" .
            "       <h1>%s</h1>" .
            "       <div>%s</div>" .
            "       <a href='#' onClick='window.history.go(-1)'>Go Back</a>" .
            "   </body>" .
            "</html>",
            $title,
            $title,
            $html
        );
    }

    /**
     * @param Exception $exception
     * @return string
     */
    private function renderExceptionFragment($exception)
    {
        $html = sprintf('<div><strong>Type:</strong> %s</div>', get_class($exception));

        $code = $exception->getCode();
        if ($code !== null) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }

        $message = $exception->getMessage();
        if ($message !== null) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', htmlentities($message));
        }

        $file = $exception->getFile();
        if ($file !== null) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }

        $line = $exception->getLine();
        if ($line !== null) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }

        $trace = $exception->getTraceAsString();
        if ($trace !== null) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', htmlentities($trace));
        }

        return $html;
    }
}
