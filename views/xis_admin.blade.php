<div style="padding-right: 2%;">

    <form>

        <h1>Settings</h1>

        <table class="form-table">
            <tr>
                <th>
                    <label>Products IDs</label>
                </th>
                <td>
                    <input type="text" id="xis_products_ids" value="{{ $xis_products_ids }}" placeholder="Products IDs (separated by comma)" style="width: 50%;">
                </td>
            </tr>
        </table>

        <div id="ajax_response_message"></div>

        <input type="button" onclick="javascript:xis_save_products_ids()" class="button button-primary bt_save_settings" value="Save Settings">

    </form>

</div>