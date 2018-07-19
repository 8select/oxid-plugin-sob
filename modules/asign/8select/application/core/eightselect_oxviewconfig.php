<?php

/**
 * oxViewConfig class wrapper for 8Select module.
 */
class eightselect_oxviewconfig extends eightselect_oxviewconfig_parent
{
    private $_blEightSelectActive = null;

    /**
     * @return bool|null
     */
    public function isEightSelectActive()
    {
        if ($this->_blEightSelectActive !== null) {
            return $this->_blEightSelectActive;
        }

        $this->_blEightSelectActive = (bool)$this->getConfig()->getConfigParam('blEightSelectActive');

        if (!$this->getEightSelectApiId()) {
            $this->_blEightSelectActive = false;
        }

        if (!$this->isPreview()) {
            $this->_blEightSelectActive = false;
        }

        return $this->_blEightSelectActive;
    }

    /**
     * @return mixed
     */
    public function getEightSelectApiId()
    {
        return $this->getConfig()->getConfigParam('sEightSelectApiId');
    }

    /**
     * @return bool
     */
    public function isPreview() {

        if ($this->getConfig()->getConfigParam('blEightSelectPreview')) {
            $blPreview = $this->getConfig()->getRequestParameter("8s_preview");
            return !is_null($blPreview);
        }

        return true;
    }

    /**
     * @param string $sWidgetType
     * @return bool
     */
    public function showEightSelectWidget($sWidgetType)
    {
        $sWidgetType = ucwords($sWidgetType, "-");
        $sWidgetType = str_replace('-', '', $sWidgetType);
        return (bool) $this->getConfig()->getConfigParam('blEightSelectWidget'.$sWidgetType);
    }
}
