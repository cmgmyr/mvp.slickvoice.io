<tr style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;box-sizing:border-box;font-size:14px;">
    <td style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;padding-top:5px;padding-bottom:5px;padding-right:0;padding-left:0;border-top-width:1px;border-top-style:solid;border-top-color:#eee;">
        {{ $item->description }}
    </td>
    <td class="alignright"
        style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;text-align:right;padding-top:5px;padding-bottom:5px;padding-right:0;padding-left:0;border-top-width:1px;border-top-style:solid;border-top-color:#eee;">
        ${{ number_format($item->price, 2) }}
    </td>
</tr>
