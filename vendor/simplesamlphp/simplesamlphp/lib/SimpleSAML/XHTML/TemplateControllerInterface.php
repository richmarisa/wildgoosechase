<?php

namespace SimpleSAML\XHTML;

/**
 * Interface that allows modules to run several hooks for templates.
 *
 * @package SimpleSAMLphp
 */
interface TemplateControllerInterface {

    /**
     * Implement to modify the twig environment after its initialization (e.g. add filters or extensions).
     *
     * @param \Twig_Environment $twig The current twig environment.
     *
     * @return void
     */
    public function setUpTwig(\Twig_Environment &$twig);


    /**
     * Implement to add, delete or modify the data passed to the template.
     *
     * This method will be called right before displaying the template.
     *
     * @param array $data The current data used by the template.
     *
     * @return void
     */
    public function display(&$data);
}
