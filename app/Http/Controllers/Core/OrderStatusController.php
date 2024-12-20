<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\OrderStatus;
use App\Models\TranslateOrderStatus;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Displays a list of all the branches in the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function allOrderStatus()
    {
        $status_list = OrderStatus::all();
        return view('settings.order_status.index', compact('status_list'));
    }

    /**
     * create new order status.
     *
     * @param Request $request
     * @return void
     */
    public function createOrderStatus(Request $request)
    {
        $request->validate([
            'status_name' => 'required|unique:core_order_status,name',
        ]);

        try {
            $order_status              = new OrderStatus();
            $order_status->name = $request->status_name;
            $order_status->saveOrFail();

            Toastr::success('Order status created successfully', 'Success');
            return back();
        } catch (Exception $ex) {
            Toastr::error('Unable to create order status', 'Error');
            return back();
        }
    }

    /**
     * update order status.
     *
     * @param Request $request
     * @return void
     */
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:core_order_status,id',
            'status_name' => 'required|unique:core_order_status,name,' . $request->id,
        ]);

        try {
            $default_lang   = getGeneralSettingsValue('default_lang');
            $translate_into = $request['translate_into'];
            if ($default_lang == $translate_into) {
                $order_status              = OrderStatus::find($request->id);
                $order_status->name = $request->status_name;
                $order_status->update();
            } else {
                $this->setOrderStatusTranslation($request);
            }
            Toastr::success('Order status updated successfully', 'Success');
            return back();
        } catch (Exception $ex) {
            Toastr::error('Unable to update order status', 'Error');
            return back();
        }
    }

    /**
     * update order status.
     *
     * @param Request $request
     * @return void
     */
    public function setOrderStatusTranslation(Request $request)
    {
        $order_status_id      = $request['id'];
        $translate_into = $request['translate_into'];

        $has_previous_trans = TranslateOrderStatus::where('order_status_id', $order_status_id)
            ->where('lang_id', $translate_into);

        if ($has_previous_trans->exists()) {
            $trans_row_id = $has_previous_trans->first()->id;
            $order_status_trans = TranslateOrderStatus::find($trans_row_id);
            $order_status_trans->order_status_id = $order_status_id;
            $order_status_trans->lang_id = $translate_into;
            $order_status_trans->name = $request['status_name'];
            $order_status_trans->update();
        } else {
            $order_status_trans = new TranslateOrderStatus();
            $order_status_trans->order_status_id = $order_status_id;
            $order_status_trans->lang_id = $translate_into;
            $order_status_trans->name = $request['status_name'];
            $order_status_trans->saveOrFail();
        }
    }

    /**
     * get translated order status.
     *
     * @param Request $request
     * @return void
     */
    public function getStatusTranslation(Request $request)
    {
        $lang_id   = $request['lang_id'];
        $order_status_id = $request['status_id'];

        $translated_order_status = TranslateOrderStatus::where('order_status_id', $order_status_id)
            ->where('lang_id', $lang_id)->first();

        if ($translated_order_status) {
            return response()->json([
                'success' => 1,
                'data'    => [
                    'name'    => $translated_order_status->name
                ],
                'message' => translate('Translated order status name'),
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data'    => [],
                'message' => translate('No translation found'),
            ]);
        }
    }

    /**
     * delete order status.
     *
     * @param Request $request
     * @return void
     */
    public function deleteOrderStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:core_order_status,id',
        ]);

        try {
            $order_status = OrderStatus::find($request['id']);
            $order_status->delete();
            Toastr::success('Order status deleted successfully', 'Success');
            return back();
        } catch (Exception $ex) {
            Toastr::error('Unable to delete order status', 'Error');
            return back();
        }
    }
}
