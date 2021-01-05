<?php

class ViewEngine {
    private $view;
    private $data;

    public function setView($view)
    {
        $fileName =  __DIR__."/../../views/$view.html";
        if (!file_exists($fileName)) {
            throw new Exception("View $view not found in views folder");
        }

        $this->view = $fileName;
        return $this;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function render() {
        $contents = file_get_contents($this->view);
        preg_match_all('#\{(.*?)\}#', $contents, $matches);
        $matches = $matches[1];
        $newContents = $contents;
        foreach ($matches as $match) {
            if (isset($this->data[$match])) {
                $newContents = preg_replace("/{".$match."}/", $this->data[$match], $newContents);
            }
        }
        echo html_entity_decode($newContents);
    }
}