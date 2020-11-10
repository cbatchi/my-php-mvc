<h1>Register form</h1>

<?php $form = \App\Core\Form\Form::beginTag('', 'POST'); ?>

  <div class="row">
    <?php foreach ($form->fieldTypes() as $key => $value) echo $form->field($model, $key)->setTypeField($value); ?>
    <div class="col-md-12">
      <p class="text-primary">Already an account ? <a href="/login">login</a></p>
      <input type="submit" value="Register" class="btn btn-primary">
    </div>
  </div>

<?php App\Core\Form\Form::endTag(); ?>

  