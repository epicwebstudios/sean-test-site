<? $info = get_item(1, $database[0]); ?>

<? ini_set('display_errors',1); ?>
<div class="ca title_box">

    <div class="l">
        <h1>Editing <? echo $item_capital; ?></h1>
    </div>

    <div class="r">
    </div>

</div>


<form
        id="page_editor"
        method="post"
        enctype="multipart/form-data"
        action="<? echo $base_url; ?>"
>

    <? field_hidden('id', $info['id']); ?>

    <table class="form">
        <thead>
        <tr>
            <td colspan="2"><? echo $item_capital; ?> Information</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="left">Entries Per Page:</td>
            <td class="right">
                Display <? field_text('per_page', $info['per_page'], 'width: 40px; text-align: center;'); ?> entries per
                page.
            </td>
        </tr>
        </tbody>
    </table>
    &nbsp;
    <table class="form">
        <thead>
        <tr>
            <td colspan="2">Share Platforms</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="left">Select Sharing Platform:</td>
            <? $share_options = explode(",", $info['share_options']); ?>
            <td class="right">
                <ul class="share-list">
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="facebook" value="1" id="facebook" <? checked($share_options, '1'); ?>/>
                            <div class="state">
                                <label for="facebook">Facebook</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="twitter" value="2" id="twitter" <? checked($share_options, '2'); ?>/>
                            <div class="state">
                                <label for="twitter">Twitter</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="linkedin" value="3" id="linkedin" <? checked($share_options, '3'); ?>/>
                            <div class="state">
                                <label for="linkedin">Linkedin</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="reddit" value="4" id="reddit" <? checked($share_options, '4'); ?>/>
                            <div class="state">
                                <label for="reddit">Reddit</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="pinterest" value="5" id="pinterest" <? checked($share_options, '5'); ?>/>
                            <div class="state">
                                <label for="pinterest">Printerest</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="pretty p-default p-round p-thick">
                            <input type="checkbox" name="email" value="6" id="email" <? checked($share_options, '6'); ?>/>
                            <div class="state">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
        </tbody>
    </table>

    &nbsp;

    <div>

        <input
                type="submit"
                name="edit_sub"
                value="Save <? echo $item_capital; ?>"
        >

    </div>

</form>

<? browser_title('Editing ' . $item_capital); ?>




