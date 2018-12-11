import { Component, OnInit } from '@angular/core';
import {SearchedTransactionModel, SearchTransactionModel} from "../models/searchTransaction.model";
import {DatePipe} from "@angular/common";
import {searchTransactionService} from "../services/searchTransaction.service";
import {AlertService} from "../../services/alert.service";


@Component({
  selector: 'app-search-transaction',
  templateUrl: './searchTransaction.component.html',
  styleUrls: ['./searchTransaction.component.scss']
})
export class SearchTransactionComponent implements OnInit {

  constructor(private z: searchTransactionService, private datePipe: DatePipe, private x: AlertService) { }

  searchTransactions: SearchTransactionModel = <SearchTransactionModel>{};
  searchedTransactions: SearchedTransactionModel[] = [];
  sentAmount: number = 0;
  receivedAmount: number = 0;

  ngOnInit() {
  }

  reset(){
    this.searchTransactions = <SearchTransactionModel>{};
  }

  search()
{
  let transformedStartDate = this.datePipe.transform(this.searchTransactions.startDate, 'yyyy/MM/dd');
  let transformedEndDate = this.datePipe.transform(this.searchTransactions.endDate, 'yyyy/MM/dd');

  this.searchTransactions.startDate = transformedStartDate;
  this.searchTransactions.endDate = transformedEndDate;

  this.z.getTransaction(this.searchTransactions).subscribe((result) => {
    this.sentAmount = result.totalAmountSent;
    this.receivedAmount = result.totalAmountReceived;
    this.searchedTransactions = result.transactions;

    if(this.receivedAmount == null){
      this.receivedAmount = 0;
    }
    if(this.sentAmount == null){
      this.sentAmount = 0;
    }

    if(this.receivedAmount == 0 && this.sentAmount == 0) {
      this.x.error("No Transactions found for the selected Period!");
    }

  });
  }
}


