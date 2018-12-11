import { Component, OnInit } from '@angular/core';
import {SendMoneyModel} from "../models/sendMoney.model";
import {sendMoneyService} from "../services/sendMoney.service";
import {AlertService} from "../../services/alert.service";

@Component({
  selector: 'app-send-money',
  templateUrl: './sendMoney.component.html',
  styleUrls: ['./sendMoney.component.scss']
})
export class SendMoneyComponent implements OnInit {

  constructor(private z: sendMoneyService, private a: AlertService) { }

  TIJNBalance = 10000;
  sendMoney: SendMoneyModel = <SendMoneyModel>{};
  amount: number;

  ngOnInit() {
    this.getBalance();
  }

  getBalance(){
    this.z.getProfileBalance().subscribe((result) => {
      this.TIJNBalance = +result.balance;
    });
  }

  submit(){
    this.z.postSendMoney(this.sendMoney).subscribe((result) => {
      console.log('TIJN Balance'+ this.TIJNBalance);
      console.log('Amount'+ this.sendMoney.amount);
      this.amount = +this.sendMoney.amount
      if(this.TIJNBalance < this.amount){
        this.a.success("Transaction successful. Payment funded from Primary Bank Account");

        console.log("Normal"+this.TIJNBalance);
      }
      else {
        this.a.success("Transaction successful.");
        console.log("From Bank Account"+this.TIJNBalance);
      }
      this.sendMoney = <SendMoneyModel>{};  // emptying the textboxes
      this.getBalance();
    });
  }

}
