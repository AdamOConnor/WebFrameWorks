<?php
namespace Itb;

class MainController
{

    /**
     * @param \Twig_Environment   $twig
     */
    public function registerAction(\Twig_Environment $twig)
    {
        $argsArray = [];
        $template = 'register';
        $htmlOutput = $twig->render($template . '.html.twig', $argsArray);
        print $htmlOutput;
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function contactAction(\Twig_Environment $twig)
    {
        $argsArray = [];
        $template = 'contact';
        $htmlOutput = $twig->render($template . '.html.twig', $argsArray);
        print $htmlOutput;
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function indexAction(\Twig_Environment $twig)
    {
        $argsArray = [];
        $template = 'index';
        $htmlOutput = $twig->render($template . '.html.twig', $argsArray);
        print $htmlOutput;
    }
    
    /**
     * @param \Twig_Environment   $twig
     */
    public function sitemapAction(\Twig_Environment $twig)
    {
        $argsArray = [];
        $template = 'sitemap';
        $htmlOutput = $twig->render($template . '.html.twig', $argsArray);
        print $htmlOutput;
    }
}