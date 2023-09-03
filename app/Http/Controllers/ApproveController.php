<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\EditHistory;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    public function approveField(Request $request)
    {
        $verticalPosition  = $request->scrollY;
        $approvedLog  = EditHistory::where('id', $request->approveFieldId)->first();
        $approvedLog->delete();
        return back()->with(['posY' => $verticalPosition]);
    }

    public function approveAll(Request $request)
    {
        $customerCodeAll   =  $request->allApproveCustomerCode;
        $customer    = Customers::where('CardCode', $customerCodeAll)->first();
        $allEdits  = EditHistory::where('cardCode', $customerCodeAll)->get();
        foreach ($allEdits as $edit) {
            $fieldKeyForModel = $edit->fieldName;
            $customer[$fieldKeyForModel] = $edit->newValue;
            $customer->save();
            $edit->isApproved = true;
            $edit->save();
        }

        if ($customer->CommercialRegister == "غير موجود" || $customer->CommercialRegister == null) {
            $customer->CRExpiryDate = null;
            $customer->CrCnMatch = null;
            $customer->ObCrMatch = null;
            $customer->OrgLegalStatue = null;
            $customer->save();
        }

        if ($customer->OrderBond == "غير موجود" || $customer->OrderBond == null) {
            $customer->ValueOrderException = null;
            $customer->CreationDateOrderOrException = null;
            $customer->ObCrMatch = null;
            $customer->ObSupporterIdImg = null;
            $customer->ObFrstSeeIdImg = null;
            $customer->ObScndSeeIdImg = null;
            $customer->NationalAddrFirstSupOb = null;

            $customer->ExpiryDateGuarantorPromissoryNote = null;
            $customer->ExpirationDateFirstWitness = null;
            $customer->ExpiryDateSecondWitness = null;
            $customer->ExpiryDateNationalAddressReserveGuarantor = null;
            $customer->save();
        }

        if ($customer->CommLicense == "غير موجود" ||  $customer->CommLicense == null) {
            $customer->ExpirydateCommlicense = null;
        }
        return back();
    }
}
