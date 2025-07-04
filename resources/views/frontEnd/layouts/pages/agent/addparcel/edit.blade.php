@extends('frontEnd.layouts.pages.agent.agentmaster')
@section('title', 'Dashboard')
@section('content')
<style>
    .walletbalance{
        background-color: #A53D3D;
    padding: 10px 20px;
    border-radius: 5px;
    color: #ffffff;
    display: none;
    }
</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="manage-button">
                        <div class="body-title">
                            <h5>Edit Parcel</h5>
                        </div>
                        <div class="quick-button">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="box-content">
                        <div class="row">

                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <!-- /.card-header -->
                                @if (session()->has('message'))
                                    <div class="alert alert-danger">

                                        {{ session('message') }}

                                    </div>
                                @endif
                                <!-- form start -->
                                <form role="form" action="{{ route('agent.parcel-update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" value="{{ $edit_data->id }}" name="hidden_id">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ $edit_data->recipientName }}" name="name" required
                                                    placeholder="Customer Name" required="required">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control{{ $errors->has('productName') ? ' is-invalid' : '' }}"
                                                    value="{{ $edit_data->productName }}" name="productName"
                                                    placeholder="Product Name" required="required">
                                                <input type="hidden" value="{{ $edit_data->codCharge }}" name="codCharge"
                                                    id="codCharge">
                                                <input type="hidden" value="{{ $edit_data->deliveryCharge }}"
                                                    name="deliveryCharge" id="deliveryCharge">
                                                @if ($errors->has('productName'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('productName') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- form group -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control select2{{ $errors->has('merchantId') ? ' is-invalid' : '' }}"
                                                    value="{{ old('merchantId') }}" name="merchantId" required='required'>
                                                    <option value="">Select Merchant</option>

                                                    @foreach ($merchants as $value)
                                                        <option value="{{ $value->id }}"
                                                            data-walletbalance="{{ $value->balance ?? 0 }}"
                                                            data-ins_cal_permission="{{ @$value->ins_cal_permission }}"
                                                            data-cod_cal_permission="{{ @$value->cod_cal_permission }}"
                                                            data-subs-cod_permission="{{  @$value->activeSubscription->plan->cod_permission  }}"
                                                            data-subs-insurance_permission="{{  @$value->activeSubscription->plan->insurance_permission  }}"
                                                            data-subs-del_crg_discount_percentage="{{ @$value->activeSubscription ? $value->activeSubscription->plan->del_crg_discount_percentage : 0 }}"
                                                            @if ($value->id == $edit_data->merchantId) selected @endif>{{ $value->companyName }}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('merchantId'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('merchantId') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select type="text"
                                                    class="pickupcity select2 form-control{{ $errors->has('pickupcity') ? ' is-invalid' : '' }}"
                                                    value="{{ old('pickupcity') }}" name="pickupcity" id="pickupcity"
                                                    required="required">
                                                    <option value="" disabled>Pickup City</option>
                                                    @foreach ($wcities as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($value->id == $edit_data->pickup_cities_id) selected @endif>
                                                            {{ $value->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('pickupcity'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('pickupcity') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select type="text"
                                                    class="pickuptown select2 form-control{{ $errors->has('pickuptown') ? ' is-invalid' : '' }}"
                                                    value="{{ old('pickuptown') }}" name="pickuptown" required="required">
                                                    @foreach ($wtowns as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($value->id == $edit_data->pickup_town_id) selected @endif>
                                                            {{ $value->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('pickuptown'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('pickuptown') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <?php
                                            $DelCities = \App\ChargeTarif::where('pickup_cities_id', $edit_data->pickup_cities_id)->with('deliverycity')->get();
                                            
                                            ?>

                                            <div class="form-group">

                                                <select type="text"
                                                    class=" select2 deliverycity form-control{{ $errors->has('deliverycity') ? ' is-invalid' : '' }}"
                                                    value="{{ old('deliverycity') }}" name="deliverycity" id="deliverycity"
                                                    required="required">
                                                    @foreach ($DelCities as $value)
                                                        <option value="{{ $value->delivery_cities_id }}"
                                                            data-deliverycharge="{{ $value->deliverycharge }}"
                                                            data-codcharge="{{ $value->codcharge }}"
                                                            data-tax="{{ $value->tax }}"
                                                            data-insurance="{{ $value->insurance }}"
                                                            data-cityid="{{ $value->delivery_cities_id }}"
                                                            data-extradeliverycharge="{{ $value->extradeliverycharge }}"
                                                            @if ($value->delivery_cities_id == $edit_data->delivery_cities_id) selected @endif>
                                                            {{ $value->deliverycity->title }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('deliverycity'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('deliverycity') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select type="text"
                                                    class="deliverytown select2 form-control{{ $errors->has('deliverytown') ? ' is-invalid' : '' }}"
                                                    value="{{ old('deliverytown') }}" name="deliverytown"
                                                    required="required">
                                                    @foreach ($delTowns as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($value->id == $edit_data->delivery_town_id) selected @endif
                                                            data-towncharge="{{ $value->towncharge }}">
                                                            {{ $value->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('deliverytown'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('deliverytown') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control{{ $errors->has('percelType') ? ' is-invalid' : '' }}"
                                                    name="percelType" required="required">
                                                    <option value="">Select Parcel Type</option>
                                                    <option value="1"
                                                        @if ($edit_data->percelType == 1) selected @endif>Regular</option>
                                                    <option value="2"
                                                        @if ($edit_data->percelType == 2) selected @endif>Liquid</option>
                                                    <option value="3"
                                                        @if ($edit_data->percelType == 3) selected @endif>Fragile</option>
                                                </select>
                                                @if ($errors->has('percelType'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('percelType') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control{{ $errors->has('phonenumber') ? ' is-invalid' : '' }}"
                                                    value="{{ $edit_data->recipientPhone }}" name="phonenumber"
                                                    id="phonenumber" placeholder="0802 123 4567" required="required">
                                                <div class="nigeria-flag"></div>
                                                @if ($errors->has('phonenumber'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($edit_data->parcel_source !== 'p2p')
                                            <div class="col-sm-6 ">
                                                <div class="form-group">
                                                    <select type="text"
                                                        class="select2 form-control{{ $errors->has('payment_option') ? ' is-invalid' : '' }}"
                                                        value="{{ old('payment_option') }}" name="payment_option"
                                                        placeholder="Delivery Area" required="required"
                                                        id="payment_option">
                                                        <option value="">Payment Option</option>
                                                        <option value="1"
                                                            @if ($edit_data->payment_option == 1) selected @endif>Prepaid
                                                        </option>
                                                        <option value="2"
                                                            @if ($edit_data->payment_option == 2) selected @endif>Pay on
                                                            Delivery</option>
                                                    </select>
                                                    @if ($errors->has('payment_option'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('payment_option') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if ($edit_data->parcel_source == 'p2p')
                                            <div class="col-sm-6" id="package_valueSHow">
                                                <div class="form-group">
                                                    <input type="hidden" name="parcel_source" id="parcel_source" value="{{$edit_data->parcel_source}}">
                                                    <input type="hidden" name="p2p_payment_option" id="p2p_payment_option" value="{{$edit_data->p2p_payment_option}}">
                                                    <input type="text" class="form-control CommaSeperateValueSet"
                                                        value="{{ $edit_data->package_value }}" name="package_value"
                                                        min="0" placeholder="Declared Value" id="package_value">

                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-6" id="cod">
                                                <div class="form-group">
                                                    <input type="text"
                                                        class="calculate CommaSeperateValueSet cod form-control{{ $errors->has('cod') ? ' is-invalid' : '' }}"
                                                        value="{{ $edit_data->cod }}" name="cod" min="0"
                                                        placeholder="Cash Collection Amount" required="required"
                                                        @if ($edit_data->payment_option == 1) readonly @endif>
                                                    @if ($errors->has('cod'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('cod') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($edit_data->payment_option != 1)
                                                <style>
                                                    #package_valueSHow {
                                                        display: none;
                                                    }
                                                </style>
                                            @endif
                                            <div class="col-sm-4" id="package_valueSHow">
                                                <div class="form-group">
                                                    <input type="text" class="form-control CommaSeperateValueSet"
                                                        value="{{ $edit_data->package_value }}" name="package_value"
                                                        value="0" min="0" placeholder="Declared Value"
                                                        id="package_value"
                                                        @if ($edit_data->payment_option == 1) required @endif>


                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-6" id="weight">
                                            <div class="form-group">
                                                <input type="number"
                                                    class="calculate weight form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}"
                                                    value="{{ $edit_data->productWeight }}" name="weight"
                                                    placeholder="Weight in KG" required="required">
                                                @if ($errors->has('weight'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('weight') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="calculate form-control{{ $errors->has('order_number') ? ' is-invalid' : '' }}"
                                                    min="0" value="{{ $edit_data->order_number }}" name="order_number"
                                                    placeholder="Order Number" required="required">
                                                @if ($errors->has('order_number'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('order_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="number"
                                                    class="calculate form-control{{ $errors->has('productQty') ? ' is-invalid' : '' }}"
                                                    min="0" value="{{ $edit_data->productQty }}"
                                                    name="productQty" placeholder="Product Quantity" required="required">
                                                @if ($errors->has('productQty'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('productQty') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control{{ $errors->has('productColor') ? ' is-invalid' : '' }}"
                                                    value="{{ $edit_data->productColor }}" name="productColor"
                                                    placeholder="Product Color" required="required">
                                                @if ($errors->has('productColor'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('productColor') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address"
                                                    placeholder="Customer Full Address" required="required">{{ $edit_data->recipientAddress }}</textarea>
                                                @if ($errors->has('address'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <textarea type="text" name="note" class="form-control" placeholder="Note" required="required">{{ $edit_data->note }}</textarea>
                                                @if ($errors->has('note'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('note') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit"
                                                    class="form-control btn btn-primary">Update</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- col end -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="parcel-details-instance">
                                    <h2>Delivery Charge Details</h2>
                                    <div class="content calculate_result">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>Cash Collection</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span
                                                        class="cashCollection">{{ number_format($edit_data->cod, 2) }}</span>
                                                    N</p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>Delivery Charge</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span
                                                        class="devlieryCharge">{{ number_format($edit_data->deliveryCharge, 2) }}</span>
                                                    N</p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>Cod Charge</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span
                                                        class="codCharge">{{ number_format($edit_data->codCharge, 2) }}</span>
                                                    N</p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>Tax</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span class="tax">{{ number_format($edit_data->tax, 2) }}</span> N
                                                </p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>Insurance</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span
                                                        class="insurance">{{ number_format($edit_data->insurance, 2) }}</span>
                                                    N</p>
                                            </div>
                                        </div>
                                        {{-- <hr> --}}
                                        <!-- row end -->
                                        <div class="row total-bar">
                                            <div class="col-sm-8">
                                                <p>Total Payable Amount</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p><span
                                                        class="total">{{ number_format(($edit_data->deliveryCharge + $edit_data->codCharge + $edit_data->tax + $edit_data->insurance - $edit_data->cod) * -1, 2) }}</span>
                                                    N</p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="text-center unbold">Note : <span class="">If you request
                                                        for pick up after 5pm, it will be collected on the next day</span>
                                                </p>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                    </div>
                                </div>
                                <br>
                                <div class="prcTag_section flex justify-content-between align-items-center">
                                    <h5 class="walletbalance"><strong>Merchant Wallet Balance: N<span class="walletbalanceAMnt"></span></strong> </h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .parcel-details-instance {
            background: #ddd;
        }

        .parcel-details-instance h2 {
            border-bottom: 5px solid #A53D3D;
            font-size: 22px;
            text-align: center;
            padding: 20px 0;
            font-weight: 600;
        }

        .parcel-details-instance .content {
            padding: 25px 25px;
        }

        .parcel-details-instance p {
            font-size: 17px;
            font-weight: 600;
        }

        .hr {
            height: 2px;
            width: 100%;
            background: black;
            margin-bottom: 16px;
        }

        p.unbold {
            font-weight: 500;
        }
    </style>
@endsection

@section('custom_js_scripts')
    <script>
        $(document.body).ready(function() {
            $('#pickupcity').on('change', function() {
                var city_id = $(this).val();
                if (city_id) {
                    $.ajax({
                        url: "{{ route('agent.get-town', ['cityid' => ':cityid']) }}".replace(
                            ':cityid', city_id),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="pickuptown"]').empty();
                            $('select[name="pickuptown"]').append(
                                '<option value="" selected="selected" disabled>Pickup Town</option>'
                                );
                            $.each(data, function(key, value) {
                                $('select[name="pickuptown"]').append(
                                    '<option value="' + value.id + '">' +
                                    value.title + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
            $('#pickupcity').on('change', function() {
                var city_id = $(this).val();
                if (city_id) {
                    $.ajax({
                        url: "{{ route('agent.get-tarrif', ['cityid' => ':cityid']) }}".replace(
                            ':cityid', city_id),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="deliverycity"]').empty();
                            $('select[name="deliverycity"]').append(
                                '<option value="" selected="selected" disabled>Delivery City</option>'
                                );
                            $.each(data, function(key, value) {
                                $('select[name="deliverycity"]').append(
                                    '<option value="' + value.delivery_cities_id +
                                    '" data-deliverycharge="' + value
                                    .deliverycharge + '" data-codcharge="' + value
                                    .codcharge + '" data-tax="' + value.tax +
                                    '" data-insurance="' + value.insurance +
                                    '" data-cityid="' + value.delivery_cities_id +
                                    '" data-extradeliverycharge="' + value
                                    .extradeliverycharge + '">' +
                                    value.deliverycity.title + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
            $('#deliverycity').on('change', function() {
                var city_id = $(this).find(':selected').data('cityid');
                if (city_id) {
                    $.ajax({
                        url: "{{ route('agent.get-town', ['cityid' => ':cityid']) }}".replace(
                            ':cityid', city_id),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="deliverytown"]').empty();
                            $('select[name="deliverytown"]').append(
                                '<option value="" selected="selected" disabled>Delivery Town</option>'
                                );
                            $.each(data, function(key, value) {
                                $('select[name="deliverytown"]').append(
                                    '<option value="' + value.id +
                                    '" data-towncharge="' + value.towncharge +
                                    '">' +
                                    value.title + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
            // $('#pickupOrdropOff, #merchantId').on('change', function() {
            //     var value =  $('#pickupOrdropOff').val() ?? 0;
            //     var merchantID = $('select[name="merchantId"]').val();
            //     var city_id = $('select[name="pickupcity"]').val();
            //     if (value == 1) {
            //         if (merchantID) {
            //             $.ajax({
            //                 url: "{{ url('/admin/get-merchant/') }}/" + merchantID,
            //                 type: "GET",
            //                 dataType: "json",
            //                 success: function(data) {
            //                     var d = $('select[name="addressofSender"]').empty();
            //                     $.each(data, function(key, value) {
            //                         $('select[name="addressofSender"]').append('<option value="' + value.pickLocation +  '" disable>' +
            //                             value.pickLocation + '</option>');
            //                     });
            //                 },
            //             });

            //         } else {
            //             alert('PLease Select Merchant');
            //         }


            //     } else if(value == 2) {
            //         if (city_id) {
            //             $.ajax({
            //                 url: "{{ url('/admin/get-branch/') }}/" + city_id,
            //                 type: "GET",
            //                 dataType: "json",
            //                 success: function(data) {
            //                     var d = $('select[name="addressofSender"]').empty();
            //                     $.each(data, function(key, value) {
            //                         $('select[name="addressofSender"]').append('<option value="' + value.address + '">' +
            //                             value.address + '</option>');
            //                     });
            //                 },
            //             });
            //         } else {
            //             alert('PLease Select City');
            //         }                

            //     } else {
            //         console.log('nothing');
            //     }
            // });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            @if (session()->has('open_url') && session()->get('open_url') != '')
                window.open('{{ session()->get('open_url') }}', '_blank');
            @endif
            $('select[name="payment_option"]').on('change', function() {
                var payment_option = $("#payment_option").val();
                if (payment_option == 1) {
                    $(".cod").val(0);
                    $(".cod").attr("readonly", true);
                    $("#package_value").attr("required", true);
                    $("#package_valueSHow").show();
                    $("#weight").removeClass('col-sm-6');
                    $("#weight").addClass('col-sm-4');
                    $("#cod").removeClass('col-sm-6');
                    $("#cod").addClass('col-sm-4');
                    var walletbalance =  $('select[name="merchantId"] option:selected').data('walletbalance');
                    $(".walletbalanceAMnt").text(CurrencyFormatted(walletbalance));
                    $(".walletbalance").show();
                    $(".codCharge").text(CurrencyFormatted(0));
   

                } else {
                    $(".cod").val('');
                    $("input[name='package_value']").val('');
                    $(".cod").attr("readonly", false);
                    $("#package_value").attr("required", false);
                    $("#package_valueSHow").hide();
                    $("#weight").removeClass('col-sm-4');
                    $("#weight").addClass('col-sm-6');
                    $("#cod").removeClass('col-sm-4');
                    $("#cod").addClass('col-sm-6');
                    $(".walletbalance").hide();

                }
                devlieryCharge();
                codUpdate();
            });
            $('select[name="deliverycity"]').on('change', function() {
                devlieryCharge();
                codUpdate();
            });
            $('select[name="pickupcity"]').on('change', function() {
                devlieryCharge();
                codUpdate();
            });
            $('select[name="merchantId"]').on('change', function() {
                var walletbalance = $(this).find('option:selected').data('walletbalance') ?? 0;
                var payment_option = $("#payment_option").val();
                if (payment_option == 1) {
                    $(".walletbalanceAMnt").text(CurrencyFormatted(walletbalance));
                    $(".walletbalance").show();
                }else{
                    $(".walletbalance").hide();
                }
                devlieryCharge();
                codUpdate();
            });
            $('select[name="deliverytown"]').on('change', function() {
                devlieryCharge();
                codUpdate();
            });

            $("input[name='weight']").on("keyup", function() {
                devlieryCharge();
            })

            $("input[name='cod']").on("keyup", function() {
                var cod = convertCommaSeparatedToNumber($("input[name='cod']").val());
                var formated = CurrencyFormatted(cod);
                var formated = checkNan(formated);
                $(".cashCollection").text(formated);
                codUpdate();
                devlieryCharge();
            })

            $("input[name='package_value']").on("keyup", function() {
                var cod = convertCommaSeparatedToNumber($("input[name='package_value']").val());
                var formated = CurrencyFormatted(cod);
                var formated = checkNan(formated);
                $(".cashCollection").text('00');
                codUpdate();
                devlieryCharge();
            })

            function codUpdate() {
                var cod_cal_permission = $('select[name="merchantId"] option:selected').data('cod_cal_permission');
                console.log(cod_cal_permission);
                var formated;

                if (cod_cal_permission == 0) {
                    formated = CurrencyFormatted(0); // If permission is 0, the charge is 0
                } else {
                    var cash = convertCommaSeparatedToNumber($("input[name='cod']").val()) ?? 0;
                    var charge = $('select[name="deliverycity"] option:selected').attr('data-codcharge') ?? 0;

                    // Calculate the charge based on selected city or default to 0
                    var chargeValue = charge ? parseFloat(cash) * (parseFloat(charge) / 100) : 0;
                    formated = CurrencyFormatted(chargeValue);
                }

                // Ensure the value is not NaN
                formated = checkNan(formated);

               // Get the COD permission from the backend, default to 1 (COD allowed) if no plan
               var codPermission =  $('select[name="merchantId"] option:selected').data('subs-cod_permission');
               console.log('codPermission ' + codPermission);
               if (codPermission == 0 && cod_cal_permission == 0) {
                    $(".codCharge").text(0); // COD allowed, no charge
                } else {
                    $(".codCharge").text(formated); // Discount or COD not allowed
                }
            }

            function devlieryCharge() {
                var formated;
                var ins_cal_permission = $('select[name="merchantId"] option:selected').data('ins_cal_permission');
                var cod_cal_permission = $('select[name="merchantId"] option:selected').data('cod_cal_permission');

                var payment_option = $("#payment_option").val();
                console.log('payment_option ' + payment_option);
                var stateCharge = $('select[name="deliverycity"] option:selected').attr('data-deliverycharge') ?? 0;
                console.log('stateCharge ' + stateCharge);
                var extraCharge = $('select[name="deliverycity"] option:selected').attr(
                    'data-extradeliverycharge') ?? 0;
                var cod = $('select[name="deliverycity"] option:selected').attr('data-codcharge') ?? 0;
                var zoneCharge = $('select[name="deliverytown"] option:selected').attr("data-towncharge") ?? 0;
                console.log('zoneCharge ' + zoneCharge);
                // Cash calculation based on payment option
                var cash;
                if (payment_option == 1) {
                    cash = parseFloat(convertCommaSeparatedToNumber($("input[name='package_value']").val())) || 0;
                } else {
                    cash = parseFloat(convertCommaSeparatedToNumber($("input[name='cod']").val())) || 0;
                }
                console.log('cash ' + cash);
                var weight = $("input[name='weight']").val();
                var taxPercent = $('select[name="deliverycity"] option:selected').attr("data-tax");
                var insurancePercent = $('select[name="deliverycity"] option:selected').attr("data-insurance");
                extraCharge = parseInt(weight) > 1 ? (parseInt(weight) * parseInt(extraCharge)) - parseInt(
                    extraCharge) : 0;

                stateCharge = stateCharge ? stateCharge : 0;
                zoneCharge = zoneCharge ? zoneCharge : 0;
                charge = parseInt(stateCharge) + parseInt(extraCharge) + parseInt(zoneCharge);
                console.log('charge ' + charge);
                // check Active Plan
                var delChargeCommission = parseFloat($('select[name="merchantId"] option:selected').data('subs-del_crg_discount_percentage'));
                // Apply discount if any
                if (delChargeCommission > 0) {
                    var discountAmount = charge * (delChargeCommission / 100);
                    charge = charge - discountAmount;
                }
                var formatCharge = CurrencyFormatted(charge);
                formatCharge = checkNan(formatCharge);
                $(".devlieryCharge").text(formatCharge);
                var codPermission =  $('select[name="merchantId"] option:selected').data('subs-cod_permission');;
                
                if (codPermission == 0 && cod_cal_permission == 0) {
                    var codcharge = 0;
                } else {
                    var codcharge = parseFloat(cash) * (cod / 100);
                    var codformated = CurrencyFormatted(codcharge);
                        codformated = checkNan(codformated);
                        if (payment_option == 1) {
                            $(".codCharge").text(0); // Discount or COD not allowed
                        }else{
                            $(".codCharge").text(codformated); // Discount or COD not allowed
                        }
                }


                // 7.5% tax CALCULATION
                var tax = charge * (taxPercent / 100);
                var formated = CurrencyFormatted(tax);
                formated = checkNan(formated);
                $(".tax").text(formated);
                console.log('tax ' + tax);

                 // Get insurance permission from backend
                  // Get insurance permission from backend
                  var InsPermission =  $('select[name="merchantId"] option:selected').data('subs-insurance_permission');            
                if ((isNaN(InsPermission) || InsPermission == 0) && ins_cal_permission == 0) {
                    var insurance = 0;
                } else {
                    var insurance = parseFloat(cash) * (insurancePercent / 100);
                }

                var formated = CurrencyFormatted(insurance);
                formated = checkNan(formated);
                console.log('insurance ' + insurance);
                $(".insurance").text(formated);


                var total;
                if (payment_option == 1) {
                    total = charge + tax + insurance;
                } else {
                    total = (charge + codcharge + tax + insurance) - parseFloat(cash);
                }
                console.log('total ' + total);
                total = total * -1;
                total = CurrencyFormatted(total);
                total = checkNan(total);
                $(".total").text(total);
            }

            function checkNan(total) {
                var str = total.split(".");
                if (str[0] == 'NaN') {
                    return '00';
                }
                return total;
            }

            function CurrencyFormatted(number) {
                var decimalplaces = 2;
                var decimalcharacter = ".";
                var thousandseparater = ",";
                number = parseFloat(number);
                var sign = number < 0 ? "-" : "";
                var formatted = new String(number.toFixed(decimalplaces));
                if (decimalcharacter.length && decimalcharacter != ".") {
                    formatted = formatted.replace(/\./, decimalcharacter);
                }
                var integer = "";
                var fraction = "";
                var strnumber = new String(formatted);
                var dotpos = decimalcharacter.length ? strnumber.indexOf(decimalcharacter) : -1;
                if (dotpos > -1) {
                    if (dotpos) {
                        integer = strnumber.substr(0, dotpos);
                    }
                    fraction = strnumber.substr(dotpos + 1);
                } else {
                    integer = strnumber;
                }
                if (integer) {
                    integer = String(Math.abs(integer));
                }
                while (fraction.length < decimalplaces) {
                    fraction += "0";
                }
                temparray = new Array();
                while (integer.length > 3) {
                    temparray.unshift(integer.substr(-3));
                    integer = integer.substr(0, integer.length - 3);
                }
                temparray.unshift(integer);
                integer = temparray.join(thousandseparater);
                return sign + integer + decimalcharacter + fraction;
            }

        });
    </script>
@endsection
