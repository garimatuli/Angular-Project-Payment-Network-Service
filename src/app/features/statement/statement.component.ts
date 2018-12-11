import { Component, OnInit } from '@angular/core';
import {statementService} from "../services/statement.service";
import { StatementModel } from "../models/statement.model";
import { DatePipe } from "@angular/common";
import {AlertService} from "../../services/alert.service";



@Component({
  selector: 'app-statement',
  templateUrl: './statement.component.html',
  styleUrls: ['./statement.component.scss']
})
export class StatementComponent implements OnInit {

  constructor(private z: statementService, private datePipe: DatePipe, private x: AlertService) { }

  statement: StatementModel = <StatementModel>{};
  sentAmount: number = 0;
  receivedAmount: number = 0;

  ngOnInit() {
     }

  reset(){
    this.statement = <StatementModel>{};
    this.receivedAmount = 0;
    this.sentAmount = 0;
  }

  search(){
    let transformedStartDate = this.datePipe.transform(this.statement.startDate, 'yyyy/MM/dd');
    let transformedEndDate = this.datePipe.transform(this.statement.endDate, 'yyyy/MM/dd');

    this.statement.startDate = transformedStartDate;
    this.statement.endDate = transformedEndDate;

   this.z.getStatement(this.statement).subscribe((result) => {
     this.sentAmount = result.totalAmountSent;
     this.receivedAmount = result.totalAmountReceived;

     if(this.receivedAmount == null){
       this.receivedAmount = 0;
     }
     if(this.sentAmount == null){
       this.sentAmount = 0;
     }

     if(this.receivedAmount == 0 && this.sentAmount == 0){
       this.x.error("No Transactions found for the selected Period!");
     }
   });
  }

}
