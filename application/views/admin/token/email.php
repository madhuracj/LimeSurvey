<?php echo PrepareEditorScript(true, $this); ?>
<div class='header ui-widget-header'>
<?php eT("Send email invitations"); ?></div>
<div><br/>

    <?php if ($thissurvey[$baselang]['active'] != 'Y')
        { ?>
        <div class='messagebox ui-corner-all'><div class='warningheader'><?php eT('Warning!'); ?></div><?php eT("This survey is not yet activated and so your participants won't be able to fill out the survey."); ?></div>
        <?php } ?>
    <div id='tabs'>
        <ul>
            <?php
                foreach ($surveylangs as $language)
                {
                    echo '<li><a href="#' . $language . '">' . getLanguageNameFromCode($language, false);
                    if ($language == $baselang)
                    {
                        echo "(" . gT("Base language") . ")";
                    }
                    echo "</a></li>";
                }
            ?>
        </ul>
        <?php echo CHtml::form(array("admin/tokens/sa/email/surveyid/{$surveyid}"), 'post', array('id'=>'sendinvitation', 'name'=>'sendinvitation', 'class'=>'form30')); ?>
            <?php
                foreach ($surveylangs as $language)
                {
                    //GET SURVEY DETAILS
                    if ($ishtml === true)
                    {
                        $aDefaultTexts = templateDefaultTexts($bplang);
                    }
                    else
                    {
                        $aDefaultTexts = templateDefaultTexts($bplang, 'unescaped');
                    }
                    if (!$thissurvey[$language]['email_invite'])
                    {
                        if ($ishtml === true)
                        {
                            $thissurvey[$language]['email_invite'] = HTMLEscape($aDefaultTexts['invitation']);
                        }
                        else
                        {
                            $thissurvey[$language]['email_invite'] = $aDefaultTexts['invitation'];
                        }
                    }
                    if (!$thissurvey[$language]['email_invite_subj'])
                    {
                        $thissurvey[$language]['email_invite_subj'] = $aDefaultTexts['invitation_subject'];
                    }
                    $fieldsarray["{ADMINNAME}"] = $thissurvey[$baselang]['adminname'];
                    $fieldsarray["{ADMINEMAIL}"] = $thissurvey[$baselang]['adminemail'];
                    $fieldsarray["{SURVEYNAME}"] = $thissurvey[$language]['name'];
                    $fieldsarray["{SURVEYDESCRIPTION}"] = $thissurvey[$language]['description'];
                    $fieldsarray["{EXPIRY}"] = $thissurvey[$baselang]["expiry"];

                    $subject = Replacefields($thissurvey[$language]['email_invite_subj'], $fieldsarray, false);
                    $textarea = Replacefields($thissurvey[$language]['email_invite'], $fieldsarray, false);
                    if ($ishtml !== true)
                    {
                        $textarea = str_replace(array('<x>', '</x>'), array(''), $textarea);
                    }
                ?>
                <div id="<?php echo $language; ?>">

                    <ul>
                        <li><label for='from_<?php echo $language; ?>'><?php eT("From"); ?>:</label>
                            <input type='text' size='50' id='from_<?php echo $language; ?>' name='from_<?php echo $language; ?>' value="<?php echo "{$thissurvey[$baselang]['adminname']} <{$thissurvey[$baselang]['adminemail']}>"; ?>" /></li>

                        <li><label for='subject_<?php echo $language; ?>'><?php eT("Subject"); ?>:</label>
                            <input type='text' size='83' id='subject_<?php echo $language; ?>' name='subject_<?php echo $language; ?>' value="<?php echo $subject; ?>" /></li>

                        <li><label for='message_<?php echo $language; ?>'><?php eT("Message"); ?>:</label>
                            <textarea name='message_<?php echo $language; ?>' id='message_<?php echo $language; ?>' rows='20' cols='80'><?php echo htmlspecialchars($textarea); ?></textarea>
                            <?php echo getEditor("email-inv", "message_$language", "[" . gT("Invitation email:", "js") . "](" . $language . ")", $surveyid, '', '', "tokens"); ?>
                        </li>
                    </ul></div>
                <?php } ?>

            <p>
                <label for='bypassbademails'><?php eT("Bypass token with failing email addresses"); ?>:</label>
                <select id='bypassbademails' name='bypassbademails'>
                    <option value='Y'><?php eT("Yes"); ?></option>
                    <option value='N'><?php eT("No"); ?></option>
                </select>
            </p>
            <p>
                <input type='submit' value='<?php eT("Send Invitations"); ?>' />
                <input type='hidden' name='ok' value='absolutely' />
                <input type='hidden' name='subaction' value='email' />
                <?php if (!empty($tokenids)) { ?>
                    <input type='hidden' name='tokenids' value='<?php echo implode('|', (array) $tokenids); ?>' />
                    <?php } ?>
            </p>
        </form>
    </div>
</div>
