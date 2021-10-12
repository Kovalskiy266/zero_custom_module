<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/koval_theme/templates/page--koval--cats.html.twig */
class __TwigTemplate_83b5c23f224e7dd7294b52418caa3bf7cd29cb17c66fc16d4cc5416d40c3e8f7 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 45
        echo "<div class=\"layout-container\">
  <header role=\"banner\">
    ";
        // line 47
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 47), 47, $this->source), "html", null, true);
        echo "
  </header>
  <main role=\"main\">
    <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 51
        echo "    <div class=\"layout-content\">
      ";
        // line 52
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 52), 52, $this->source), "html", null, true);
        echo "
    </div>";
        // line 54
        echo "  </main>
  ";
        // line 55
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 55)) {
            // line 56
            echo "    <footer role=\"contentinfo\">
      ";
            // line 57
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
            echo "
    </footer>
  ";
        }
        // line 60
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/koval_theme/templates/page--koval--cats.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 60,  64 => 57,  61 => 56,  59 => 55,  56 => 54,  52 => 52,  49 => 51,  43 => 47,  39 => 45,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/koval_theme/templates/page--koval--cats.html.twig", "/var/www/web/themes/custom/koval_theme/templates/page--koval--cats.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 55);
        static $filters = array("escape" => 47);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
