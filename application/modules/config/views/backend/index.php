<?php
/** @var \app\modules\config\models\Configurable[] $models */
use yii\helpers\Html;
use app\backend\components\ActiveForm;
use kartik\icons\Icon;
$this->title = Yii::t('app', 'Configuration');
$this->params['breadcrumbs'][] = [
    'url' => ['/config/backend/index'],
    'label' => $this->title
];
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <h1>
            <?= Yii::t('app', 'Configuration') ?>
        </h1>
    </div>
</div>

<div class="row">
    <?php
        $form = ActiveForm::begin(
                [
                    'id' => 'config-form',
                    'type'=> ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data']
                ]
        );
    ?>
    <article class="col-xs-12 col-lg-12">
        <div
            class="jarviswidget well jarviswidget-color-darken"
            id="wid-id-configurations"
            data-widget-sortable="false"
            data-widget-deletebutton="false"
            data-widget-editbutton="false"
            data-widget-colorbutton="false"
            role="widget"
        >
            <!-- widget div-->
            <div role="content">
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->
                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body no-padding">
                    <div class="widget-body-toolbar">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Type configuration name for searching (TBD)...">
                                    <div class="input-group-btn">
                                        <button class="btn btn-secondary" type="button">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8 text-align-right">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Create New value @tbd </a>
                                    <?=
                                    Html::submitButton(
                                        Icon::show('save') . ' ' . Yii::t('app', 'Save'),
                                        [
                                            'class' => 'btn btn-sm btn-primary',
                                            'name' => 'action',
                                            'value' => 'save',
                                        ]
                                    )
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="padding-10">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php
                                    $counter=0;
                                    foreach ($models as $i => $model):
                                        if ($model->display_in_config === 0) {
                                            continue;
                                        }
                                ?>
                                <button class="nav-link <?= $counter++===0 ? 'active' : '' ?>" id="v-pills-home-tab-<?= $i ?>" data-bs-toggle="pill" data-bs-target="#tab-configurable-<?=$i?>" type="button" role="tab"><?= Yii::t('app', $model->section_name) ?>
                                </button>
                                <?php endforeach; ?>
                            </div>
                            <div class="tab-content" id="v-pills-tabContent">
                                <?php
                                    $counter = 0;
                                    foreach ($models as $i => $model):
                                        if ($model->display_in_config === 0) {
                                            continue;
                                        }
                                    ?>
                                    <div class="tab-pane <?= $counter++ === 0 ? 'active' : '' ?>" id="tab-configurable-<?=$i?>">
                                        <?= $this->render(
                                                $model->getConfigurationView(),
                                            [
                                                'configurable' => $model,
                                                'form' => $form,
                                                'model' => $model->getConfigurableModel(),
                                            ])
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
    </article>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs(<<<JS
    jQuery(localStorage.getItem("configActiveTab")).click();
    jQuery("#config-control-tabs").on("show.bs.tab", "a[data-toggle='tab']", function(event) {
        localStorage.setItem("configActiveTab", "#" + event.target.id);
    });
JS
);