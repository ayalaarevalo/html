<?php

namespace Styde\Html;

use Illuminate\Contracts\View\Factory as View;

class Theme
{
    /**
     * Class used to render the views once we know which template to use.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;
    /**
     * Theme's name (i.e. bootstrap, foundation, custom, etc.)
     *
     * @var string
     */
    protected $theme;

    /**
     * Creates a Theme class, used to render custom or default templates for
     * any of the classes of this component (alert, menu, form, field)
     *
     * @param View $view
     * @param $theme
     */
    public function __construct(View $view, $theme)
    {
        $this->view = $view;
        $this->theme = $theme;
    }

    /**
     * Get the name of this theme (i.e. bootstrap or foundation)
     *
     * @return string
     */
    public function getName()
    {
        return $this->theme;
    }

    /**
     * Renders a custom template or one of the default templates.
     *
     * The default template could be published (into resources/views/themes/)
     * or be located inside the components directory (vendor/styde/html/themes/)
     *
     * @param string $custom
     * @param array $data
     * @param null $template
     * @return string
     */
    public function render($custom, $data = array(), $template = null)
    {
        if ($custom != null) {
            return $this->view->make($custom, $data)->render();
        }

        $template = $this->theme.'/'.$template;

        if ($this->view->exists("themes/$template")) {
            return $this->view->make("themes/$template", $data)->render();
        }

        return $this->view->make('styde.html::'.$template, $data)->render();
    }
}
