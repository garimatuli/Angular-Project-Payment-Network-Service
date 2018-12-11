import { Component, OnInit } from '@angular/core';
import {requestMoneyService} from "../services/requestMoney.service";
import {identifierPercentage, RequestMoneyModel} from "../models/requestMoney.model";
import {AlertService} from "../../services/alert.service";


@Component({
  selector: 'app-request-money',
  templateUrl: './requestMoney.component.html',
  styleUrls: ['./requestMoney.component.scss']
})
export class RequestMoneyComponent implements OnInit {

  constructor(private z: requestMoneyService, private a: AlertService) { }

  TIJNBalance = 10000;
  requestMoney: RequestMoneyModel = <RequestMoneyModel>{};
  AllIdentifierPercentage: identifierPercentage[] = [];
  SingleIdentifierPercentage: identifierPercentage = <identifierPercentage>{};

  ngOnInit() {
    this.getBalance();
  }

  getBalance(){
    this.z.getProfileBalance().subscribe((result) => {
      this.TIJNBalance = result.balance;
    });
  }

  addRow(){
    this.AllIdentifierPercentage.push(this.SingleIdentifierPercentage);
    this.SingleIdentifierPercentage = <identifierPercentage>{};
  }

  deleteRow(toBeDeleted: identifierPercentage){
    console.log(toBeDeleted);
    this.AllIdentifierPercentage = this.AllIdentifierPercentage.filter((resultLocal) => {
      return resultLocal !== toBeDeleted;
    })
  }

  submit(){
    this.requestMoney.details = this.AllIdentifierPercentage;
    this.z.postRequestMoney(this.requestMoney).subscribe((result) => {
      this.requestMoney = <RequestMoneyModel>{};  // emptying the textboxes
      this.getBalance();
      this.a.success("Transaction successful.");
      this.AllIdentifierPercentage = [];
    });
  }
}
