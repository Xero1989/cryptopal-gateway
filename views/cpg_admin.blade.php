<div style="padding-right: 2%;">

    <form id="cpg_form_admin">

        <h1>Settings</h1>

        <table class="form-table">
            <tr>
                <th>
                    Enable
                </th>
                <td>
                    @if($cpg_enable)
                    <input type="checkbox" id="cpg_enable" checked />
                    @else
                    <input type="checkbox" id="cpg_enable" />
                    @endif
                </td>
            </tr>
            <tr>
                <th>
                    <label>Description</label>
                </th>
                <td>
                    <textarea id="cpg_description">{{$cpg_description}}</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Webshop ID</label>
                </th>
                <td>
                    <input type="text" value="{{$cpg_webshop_id}}" id="cpg_webshop_id" />
                </td>
            </tr>
            <!-- <tr>
                <th>
                    <label>Webhook URL</label>
                </th>
                <td>
                    <input type="text" value="{{$cpg_webhook_url}}" id="cpg_webhook_url" />
                </td>
            </tr> -->
        </table>
<br>

<div id="ajax_response_message"></div>

        <input type="button" onclick="javascript:cpg_save_settings()" class="button button-primary bt_save_settings" value="Save Settings">

    </form>

</div>