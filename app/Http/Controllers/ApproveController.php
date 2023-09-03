<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\EditHistory;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    public function approveField(Request $request)
    {
        // dd($request);
        // $request->approveFieldId 
        $verticalPosition  = $request->scrollY;
        // This is the Id For the Field TO be Approved ; 
        // All you need to do is to approve Only this Field in the COlumn 
        // And Then Redirect back 
        $approvedLog  = EditHistory::where('id', $request->approveFieldId)->first();
        // $approvedLog->isApproved = true; // Delete it from Records !! 
        // $approvedLog->save();
        $approvedLog->delete();

        // $customerCode =  $approvedLog->cardCode;
        // $updatedCustomer  = Customers::where('CardCode', $customerCode)->first();
        // $fieldKeyForModel = $approvedLog->fieldName;
        // $updatedCustomer[$fieldKeyForModel] = $approvedLog->newValue;
        // $updatedCustomer->save();
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


        // Customer and Ceck > sejecl and Sanad 
        // "CommercialRegister":"السجل التجارى",
        if ($customer->CommercialRegister == "غير موجود" || $customer->CommercialRegister == null) {
            // "CRExpiryDate": "تاريخ انتهاء السجل التجارى",
            // "CrCnMatch":"مطابقة اسم العميل بالاسم بالسجل التجارى",
            // "OrgLegalStatue":"الكيان القانونى",
            // "ObCrMatch":"مطابقة رقم السجل التجارى بسند الامر",
            $customer->CRExpiryDate = null;
            $customer->CrCnMatch = null;
            $customer->ObCrMatch = null;
            $customer->OrgLegalStatue = null;
            $customer->save();
        }

        // "OrderBond":"سند الامر",
        if ($customer->OrderBond == "غير موجود" || $customer->OrderBond == null) {
            // "ValueOrderException": "قيمة سند الامر او الاستثناء",
            // "CreationDateOrderOrException": "تاريخ انشاء سند الامر او الاستثناء",
            // "ObCrMatch":"مطابقة رقم السجل التجارى بسند الامر",
            // "ObSupporterIdImg":" صورة عن هوية الضامن الاحتياطي في السند لأمر",
            // "ObFrstSeeIdImg":" صورة عن هوية الشاهد الاول في السند الامر",
            // "ObScndSeeIdImg":" صورة عن هوية الشاهد الثانى في السند الامر",
            // "NationalAddrFirstSupOb":" صورة عن العنوان الوطني للضامن الاحتياطي في سند الامر" 

            // "ExpiryDateGuarantorPromissoryNote": "تاريخ انتهاء صورة عن هوية الضامن الاحتياطي في السند لأمر",
            // "ExpirationDateFirstWitness": " تاريخ انتهاء هوية الشاهد الاول في السند الامر",
            // "ExpiryDateSecondWitness": " تاريخ انتهاء هوية الشاهد الثانى في السند الامر",
            // "ExpiryDateNationalAddressReserveGuarantor": "تاريخ انتهاء العنوان الوطني للضامن الاحتياطي في سند الامر",
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

        if ($customer->CommLicense == "غير موجود" ||  $customer->CommLicense == null )
        {
            $customer->ExpirydateCommlicense = null ; 
        }
        return back();
    }
}
