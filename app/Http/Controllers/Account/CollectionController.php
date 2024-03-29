<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bank;
use App\Dealer;
use App\Collection;
use App\Dealercommisiontarget;
use App\Lmcommisiontarget;
use App\Othertarget;
use App\Spocommisiontarget;
use App\Employee;
use App\CommissionIn;
use DB;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = DB::select('SELECT collections.id,collections.dealer_id,collections.collection_method,collections.collection_date,collections.collection_amount,collections.check_name,collections.check_number,collections.check_date,collections.bank_id,collections.description,banks.bank_name,dealers.d_s_name FROM `collections` 
        LEFT JOIN banks ON banks.id = collections.bank_id
        LEFT JOIN dealers ON dealers.id = collections.dealer_id
        ORDER BY collections.id DESC' );
        return view('Account.Collection.index',compact('collections'));
    }

    public function collection()
    {
        $dealers = Dealer::latest('id')->get();
        $banks = Bank::latest('id')->get();
        return view('Account.Collection.collection',compact('dealers','banks'));
    }

    public function storecollection(Request $request)
    {
        // dd($request);
        $collections = new Collection;
        $collections->dealer_id      = $request->dealer_id;
        $collections->collection_method      = $request->collection_method;
        $collections->collection_date      = $request->collection_date;
        $collections->collection_amount      = $request->collection_amount;
        $collections->check_name      = $request->check_name;
        $collections->check_number      = $request->check_number;
        $collections->check_date      = $request->check_date;
        $collections->bank_id      = $request->bank_id;
        $collections->description      = $request->description;
        $collections->save();
        return redirect()->route('collection.index')
                        ->with('success', 'Collection Set successfully .');

    }


    

    // Commission Incentive set 

    public function commisioninc()
    {
        $commission_inc = CommissionIn::latest('id')->get();
        return view('Account.Commission_ins.index',compact('commission_inc'));
    }

    public function commision_inc_create()
    {
        return view('Account.Commission_ins.create');
    }

    public function commision_inc_store(Request $request)
    {

        $commissionin = new CommissionIn;
        $commissionin->title      = $request->title;
        $commissionin->target_amount      = $request->target_amount;
        $commissionin->achive_commision      = $request->achive_commision;
        $commissionin->description      = $request->description;
        $commissionin->save();
        return redirect()->route('commission.incentive.index')
                        ->with('success', 'Commission Incentive Set successfully .');
    }

    public function getincinfo($id)
    {
        $getinfo = DB::select('select * from commission_ins where id = "'.$id.'"');
        return $getinfo;
    }


    // end Commission incentive Set




    // Dealer Target set
    public function dtarget()
    {
        $dCommisions = DB::select('SELECT `cominc_id`, `traget_amount`, `achieve_commistion`, `from_date`, `to_date`,commission_ins.title FROM `dealercommisiontargets`
        LEFT JOIN commission_ins ON commission_ins.id = dealercommisiontargets.cominc_id');
        return view('Account.Collectiontarget.Dealer.index',compact('dCommisions'));
    }

    public function dtargetset()
    {
        $dealers = Dealer::latest('id')->get();
        
        $commission_inc = CommissionIn::latest('id')->get();
        return view('Account.Collectiontarget.Dealer.targetset',compact('commission_inc'));
    }


    public function dealertargetset(Request $request)
    {
        $dealerstar = new Dealercommisiontarget;
        $dealerstar->cominc_id = $request->cominc_id;
        $dealerstar->traget_amount = $request->traget_amount;
        $dealerstar->achieve_commistion = $request->achieve_commistion;
        $dealerstar->from_date = $request->from_date;
        $dealerstar->to_date = $request->to_date;
        $dealerstar->description = $request->description;
        $dealerstar->save();
        return redirect()->route('dealer.collection.dtarget')
        ->with('success', 'Dealer Target Set successfully .');
    }


    // line manager
    public function lmtarget()
    {
        $lmtargets = DB::select('SELECT employees.emp_name,lmcommisiontargets.emp_id,lmcommisiontargets.traget_amount,lmcommisiontargets.achieve_commistion,lmcommisiontargets.from_date,lmcommisiontargets.to_date,lmcommisiontargets.active_status FROM `lmcommisiontargets`
        LEFT JOIN employees on employees.id = lmcommisiontargets.emp_id');
        return view('Account.Collectiontarget.Linemanager.index',compact('lmtargets'));
    }

    public function lmtargetset()
    {
        $emps   =   Employee::latest('id')->get();
        $commission_inc = CommissionIn::latest('id')->get();
        return view('Account.Collectiontarget.Linemanager.targetset',compact('emps','commission_inc'));
    }

    public function linemanagertargetset(Request $request)
    {
        $lineman = new Lmcommisiontarget;
        $lineman->emp_id = $request->emp_id;
        $lineman->traget_amount = $request->traget_amount;
        $lineman->achieve_commistion = $request->achieve_commistion;
        $lineman->from_date = $request->from_date;
        $lineman->to_date = $request->to_date;
        $lineman->description = $request->description;
        $lineman->save();
        return redirect()->route('linemanager.collection.lmtarget')
                        ->with('success', 'Line Manager Target Set successfully .');
    }


    // spo target set 
    public function starget()
    {
        $spestars = DB::select('SELECT employees.emp_name,spocommisiontargets.emp_id,spocommisiontargets.traget_amount,spocommisiontargets.achieve_commistion,spocommisiontargets.from_date,spocommisiontargets.to_date,spocommisiontargets.active_status FROM `spocommisiontargets`
        LEFT JOIN employees on employees.id = spocommisiontargets.emp_id');
        return view('Account.Collectiontarget.Spo.index',compact('spestars'));
    }

    public function stargetset()
    {
        $emps   =   Employee::latest('id')->get();
        $commission_inc = CommissionIn::latest('id')->get();
        return view('Account.Collectiontarget.Spo.targetset',compact('emps','commission_inc'));
    }

    public function spotargetset(Request $request)
    {
        $spestar = new Spocommisiontarget;
        $spestar->emp_id = $request->emp_id;
        $spestar->traget_amount = $request->traget_amount;
        $spestar->achieve_commistion = $request->achieve_commistion;
        $spestar->from_date = $request->from_date;
        $spestar->to_date = $request->to_date;
        $spestar->description = $request->description;
        $spestar->save();
        return redirect()->route('spo.collection.starget')
                        ->with('success', 'Spo Set  successfully .');
    }

    // Other target set 
    public function otarget()
    {
        $otherstars = DB::select('SELECT employees.emp_name,othertargets.emp_id,othertargets.traget_amount,othertargets.achieve_commistion,othertargets.from_date,othertargets.to_date,othertargets.active_status FROM `othertargets`
        LEFT JOIN employees on employees.id = othertargets.emp_id');
        return view('Account.Collectiontarget.Other.index',compact('otherstars'));
    }

    public function otargetset()
    {
        $emps   =   Employee::latest('id')->get();
        $commission_inc = CommissionIn::latest('id')->get();
        return view('Account.Collectiontarget.Other.targetset',compact('emps','commission_inc'));
    }
    public function othertargetset(Request $request)
    {
        $otherstar = new Othertarget;
        $otherstar->emp_id =$request->emp_id;
        $otherstar->traget_amount =$request->traget_amount;
        $otherstar->achieve_commistion =$request->achieve_commistion;
        $otherstar->from_date =$request->from_date;
        $otherstar->to_date =$request->to_date;
        $otherstar->description =$request->description;
        $otherstar->save();
        return redirect()->route('other.collection.otarget')
                        ->with('success', 'Other Target Set successfully .');
    }


}
