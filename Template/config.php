<h3>
    <i class="fa fa-amazon fa-fw" aria-hidden="true"></i>
    Amazon S3 Storage
</h3>
<div class="panel">
    <?= $this->form->label(t('AWS S3 region'), 'aws_s3_region') ?>
    <?= $this->form->text('aws_s3_region', $values) ?>

    <?= $this->form->label(t('AWS S3 bucket'), 'aws_s3_bucket') ?>
    <?= $this->form->text('aws_s3_bucket', $values) ?>

    <?= $this->form->label(t('AWS S3 objects prefix'), 'aws_s3_prefix') ?>
    <?= $this->form->text('aws_s3_prefix', $values) ?>

    <?= $this->form->label(t('AWS Access Key ID'), 'aws_access_key_id') ?>
    <?= $this->form->password('aws_access_key_id', $values) ?>

    <?= $this->form->label(t('AWS Secret Key'), 'aws_secret_access_key') ?>
    <?= $this->form->password('aws_secret_access_key', $values) ?>

    <?= $this->form->label(t('AWS S3 custom options'), 'aws_s3_options') ?>
    <?= $this->form->text('aws_s3_options', $values) ?>

    <p class="form-help"><a href="https://github.com/kanboard/plugin-s3#configuration" target="_blank"><?= t('Help on Amazon S3 integration') ?></a></p>

    <div class="form-actions">
        <button class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</div>
