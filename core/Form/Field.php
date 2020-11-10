<?php

namespace App\Core\Form;

use App\Core\Model;

/**
 * Class Field
 * @author BATCHI <claude.batchi@epitech.eu>
 * Cette classe permet de generer un champ pour tous type de formulaires
 * 
 */
class Field {

  public const TYPE = 'text';
  public Model $model;
  public string $attribute;
  public string $type;
  
  /**
   * __construct
   *
   * @param Model $model
   * @param string $attribute
   * @return void
   */
  public function __construct(Model $model, string $attribute)
  {
    $this->model = $model;
    $this->attribute = $attribute;
    $this->type = self::TYPE;
  }
  
  /**
   * __toString
   *
   * @return string
   */
  public function __toString() {
    return sprintf(
      <<<HTML
        <div class="col-md-6 col-xs-12">
          <div class="form-group">
            <label id="%s">%s</label>
            <input
              type="%s"
              name="%s"
              id="%s"
              value="%s"
              class="form-control%s"
            >
            <div class="invalid-feedback">%s</div>
          </div>
        </div>
      HTML,
        $this->attribute,
        ucfirst($this->attribute),
        $this->type,
        $this->attribute,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute) ? ' is-invalid' : null,
        $this->model->getFirstError($this->attribute) ?? null
    );
  }

  public function setTypeField ($value) {
    $this->type = empty($value) ? self::TYPE : $value;
    return $this;
  }

}