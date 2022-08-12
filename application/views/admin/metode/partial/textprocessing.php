<div class="card">
    <?php $this->view('session'); ?>
    <div class="card-header">
        <i class="fas fa-table"></i> Text Processing
    </div>
    <div class="card-body">
        <div>
            <strong>Text sentimen: </strong>
            <p><?= $sentimen['text_sentimen'] ?></p>
        </div>
        <section id="sentimen">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="caseFolding-tab" data-toggle="tab" href="#caseFolding" role="tab" aria-controls="caseFolding" aria-selected="true">Case Folding</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="cleansing-tab" data-toggle="tab" href="#cleansing" role="tab" aria-controls="cleansing" aria-selected="false">Cleansing</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tokenizing-tab" data-toggle="tab" href="#tokenizing" role="tab" aria-controls="tokenizing" aria-selected="false">Tokenizing</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="stopword-tab" data-toggle="tab" href="#stopword" role="tab" aria-controls="stopword" aria-selected="false">Stopword</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="stemming-tab" data-toggle="tab" href="#stemming" role="tab" aria-controls="stemming" aria-selected="false">Stemming</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="caseFolding" role="tabpanel" aria-labelledby="caseFolding-tab">
                    <div class="mt-3">
                        <p>
                            <?= $sentimen['caseFolding'] ?>
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="cleansing" role="tabpanel" aria-labelledby="cleansing-tab">
                    <div class="mt-3">
                        <p>
                            <?= $sentimen['cleansing'] ?>
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="tokenizing" role="tabpanel" aria-labelledby="tokenizing-tab">
                    <div class="mt-3">
                        <table class="table w-50 mx-auto">
                            <?php
                            foreach ($sentimen['tokenizing'] as $key => $value) : ?>
                                <tr>
                                    <td class="text-center"><?= $value; ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </table>

                    </div>
                </div>
                <div class="tab-pane fade" id="stopword" role="tabpanel" aria-labelledby="stopword-tab">
                    <div class="mt-3">
                        <p>
                            <?= implode(' ', $sentimen['stopword'])  ?>
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="stemming" role="tabpanel" aria-labelledby="stemming-tab">
                    <div class="mt-3">
                        <p>
                            <?= implode(' ', $sentimen['stemming'])  ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>