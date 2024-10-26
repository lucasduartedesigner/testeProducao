<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\CloudRetail;

class GoogleCloudRetailV2alphaModelModelFeaturesConfig extends \Google\Model
{
  protected $frequentlyBoughtTogetherConfigType = GoogleCloudRetailV2alphaModelFrequentlyBoughtTogetherFeaturesConfig::class;
  protected $frequentlyBoughtTogetherConfigDataType = '';
  protected $llmEmbeddingConfigType = GoogleCloudRetailV2alphaModelModelFeaturesConfigLlmEmbeddingConfig::class;
  protected $llmEmbeddingConfigDataType = '';

  /**
   * @param GoogleCloudRetailV2alphaModelFrequentlyBoughtTogetherFeaturesConfig
   */
  public function setFrequentlyBoughtTogetherConfig(GoogleCloudRetailV2alphaModelFrequentlyBoughtTogetherFeaturesConfig $frequentlyBoughtTogetherConfig)
  {
    $this->frequentlyBoughtTogetherConfig = $frequentlyBoughtTogetherConfig;
  }
  /**
   * @return GoogleCloudRetailV2alphaModelFrequentlyBoughtTogetherFeaturesConfig
   */
  public function getFrequentlyBoughtTogetherConfig()
  {
    return $this->frequentlyBoughtTogetherConfig;
  }
  /**
   * @param GoogleCloudRetailV2alphaModelModelFeaturesConfigLlmEmbeddingConfig
   */
  public function setLlmEmbeddingConfig(GoogleCloudRetailV2alphaModelModelFeaturesConfigLlmEmbeddingConfig $llmEmbeddingConfig)
  {
    $this->llmEmbeddingConfig = $llmEmbeddingConfig;
  }
  /**
   * @return GoogleCloudRetailV2alphaModelModelFeaturesConfigLlmEmbeddingConfig
   */
  public function getLlmEmbeddingConfig()
  {
    return $this->llmEmbeddingConfig;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudRetailV2alphaModelModelFeaturesConfig::class, 'Google_Service_CloudRetail_GoogleCloudRetailV2alphaModelModelFeaturesConfig');