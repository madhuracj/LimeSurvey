<div class='header'>
    <?php eT("Your personal settings"); ?>
</div>
<div>
    <?php echo CHtml::form($this->createUrl("/admin/user/sa/personalsettings"), 'post', array('class' => 'form44')); ?>
        <ul>
            <li>
                <?php 
                echo CHtml::label(gT("Interface language"), 'lang');
                ?>:
                <select id='lang' name='lang'>
                    <option value='auto'<?php if ($sSavedLanguage == 'auto') { echo " selected='selected'"; } ?>>
                        <?php eT("(Autodetect)"); ?>
                    </option>
                    <?php 
                    App()->loadHelper('surveytranslator');
                    foreach (getLanguageData(true, Yii::app()->getLanguage()) as $langkey => $languagekind)
                    {
                        echo CHtml::tag('option', array(
                            'value' => $langkey,
                            'selected' => ($langkey == $sSavedLanguage)
                        ), $languagekind['nativedescription'] . ' - ' . $languagekind['description']);
                    } ?>
                </select>
            </li>

            <li>
                <?php echo CHtml::label(gT("HTML editor mode"), 'htmleditormode'); ?>:
                <?php
                echo CHtml::dropDownList('htmleditormode', Yii::app()->session['htmleditormode'], array(
                    'default' => gT("Default"),
                    'inline' => gT("Inline HTML editor"),
                    'popup' => gT("Popup HTML editor"),
                    'none' => gT("No HTML editor")
                ));
                ?>
            </li>

            <li>
                <?php echo CHtml::label(gT("Question type selector"), 'questionselectormode'); ?>:
                <?php
                echo CHtml::dropDownList('questionselectormode', Yii::app()->session['questionselectormode'], array(
                    'default' => gT("Default"),
                    'full' => gT("Full selector"),
                    'none' => gT("Simple selector")
                ));
                ?>
            </li>

            <li>
                <?php echo CHtml::label(gT("Template editor mode"), 'templateeditormode'); ?>:
                <?php
                echo CHtml::dropDownList('templateeditormode', Yii::app()->session['templateeditormode'], array(
                    'default' => gT("Default"),
                    'full' => gT("Full template editor"),
                    'none' => gT("Simple template editor")
                ));
                ?>
            </li>

            <li>
                <?php echo CHtml::label(gT("Date format"), 'dateformat'); ?>:
                <select name='dateformat' id='dateformat'>
                <?php
                foreach (getDateFormatData(0,App()->getLanguage()) as $index => $dateformatdata)
                {
                    echo "<option value='{$index}'";
                    if ($index == Yii::app()->session['dateformat'])
                    {
                        echo " selected='selected'";
                    }

                    echo ">" . $dateformatdata['dateformat'] . '</option>';
                }
                ?>
                </select>
            </li>
        </ul>
        <p>
            <?php echo CHtml::hiddenField('action', 'savepersonalsettings'); ?>
            <?php echo CHtml::submitButton(gT("Save settings")); ?>
        </p>
    <?php echo CHtml::endForm(); ?>
</div>