<?php

class dmWidgetContentNivoGalleryView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('medias', 'method', 'fx'));

    $this->addJavascript(array('dmWidgetNivoGalleryPlugin.view',
      sfConfig::get('app_dmWidgetNivoGalleryPlugin_js')
        ? sfConfig::get('app_dmWidgetNivoGalleryPlugin_js')
        : 'dmWidgetNivoGalleryPlugin.nivo'));
    
    $this->addStylesheet(array('dmWidgetNivoGalleryPlugin.view',
      sfConfig::get('app_dmWidgetNivoGalleryPlugin_css')
        ? sfConfig::get('app_dmWidgetNivoGalleryPlugin_css')
        : 'dmWidgetNivoGalleryPlugin.nivo'));
    
  }

  protected function filterViewVars(array $vars = array())
  {
    $vars = parent::filterViewVars($vars);
    
    // extract media ids
    $mediaIds = array();
    foreach($vars['medias'] as $index => $mediaConfig)
    {
      $mediaIds[] = $mediaConfig['id'];
    }
    
    // fetch media records
    $mediaRecords = empty($mediaIds) ? array() : $this->getMediaQuery($mediaIds)->fetchRecords()->getData();
    
    // sort records
    $this->mediaPositions = array_flip($mediaIds);
    usort($mediaRecords, array($this, 'sortRecordsCallback'));
    
    // build media tags
    $medias = array();
    foreach($mediaRecords as $index => $mediaRecord)
    {
      $mediaTag = $this->getHelper()->media($mediaRecord);
  
      if (!empty($vars['width']) || !empty($vars['height']))
      {
        $mediaTag->size(dmArray::get($vars, 'width'), dmArray::get($vars, 'height'));
      }
  
      $mediaTag->method($vars['method']);
  
      if ($vars['method'] === 'fit')
      {
        $mediaTag->background($vars['background']);
      }
      
      if ($alt = $vars['medias'][$index]['alt'])
      {
        $mediaTag->alt($this->__($alt));
      }
      
      if ($quality = dmArray::get($vars, 'quality'))
      {
        $mediaTag->quality($quality);
      }
      
      $medias[] = array(
        'tag'   => $mediaTag,
        'link'  => $vars['medias'][$index]['link']
      );
    }
  
    // replace media configuration by media tags
    $vars['medias'] = $medias;
    
    return $vars;
  }
  
  protected function sortRecordsCallback(DmMedia $a, DmMedia $b)
  {
    return $this->mediaPositions[$a->get('id')] > $this->mediaPositions[$b->get('id')];
  }
  
  protected function getMediaQuery($mediaIds)
  {
    return dmDb::query('DmMedia m')
    ->leftJoin('m.Folder f')
    ->whereIn('m.id', $mediaIds);
  }

  protected function doRender()
  {
    if ($this->isCachable() && $cache = $this->getCache())
    {
      return $cache;
    }
    
    $vars = $this->getViewVars();
    $helper = $this->getHelper();
    $count = count($vars['medias']);
    
    $html = $helper->open('div#dm_widget_nivo_gallery_container');
    $html .= $helper->open('div#dm_widget_nivo_gallery', array('json' => array(
      'fx'             => dmArray::get($vars, 'fx', '0.5', 'fade'),
      'animspeed'      => dmArray::get($vars, 'animspeed', 0.5),
      'pausetime'      => dmArray::get($vars, 'pausetime', 3),
      'width'          => dmArray::get($vars, 'width'),
      'height'         => dmArray::get($vars, 'height'),
      'count'          => $count
    )));
    
    foreach($vars['medias'] as $media)
    {
      $html .= $media['link'] ? $helper->link($media['link'])->text($media['tag']) : $media['tag'];
    }
    
    $html .= '</div></div>';

    // add media numbers
//    if (isset($vars['show_pager']) && $vars['show_pager'])
//    {
//      $html .= $helper->open('div#mediaPager'.$this->widget['id'].'.pager');
//      $html .= $helper->close('div');
//    }

    
    if ($this->isCachable())
    {
      $this->setCache($html);
    }
    
    return $html;
  }
  
  protected function doRenderForIndex()
  {
    $alts = array();
    foreach($this->compiledVars['medias'] as $media)
    {
      if (!empty($media['alt']))
      {
        $alts[] = $media['alt'];
      }
    }
    
    return implode(', ', $alts);
  }
  
}