import { Injectable } from '@angular/core';

import {Observable, of} from 'rxjs';
import {HttpResponse, HttpHeaders} from "@angular/common/http";
import { HttpClient } from "@angular/common/http";

import {UserInfoService} from "../../services/user-info.service";
import {SendMoneyModel} from "../models/sendMoney.model";

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json;',
    //  'Content-Type':  'application/x-www-form-urlencoded; charset=UTF-8'
    'Cache-Control': 'no-cache',
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
    'Access-Control-Max-Age': '1728000'
  })
};

@Injectable()

export class sendMoneyService {

  constructor(private http: HttpClient, private x: UserInfoService) { }

  getProfileBalance(){
    let currentSSN = this.x.getSSN();
    return <Observable<any>> this.http.get("http://localhost/dbms/getBalance?ssn="+currentSSN);
  }

  postSendMoney(sendMoney:SendMoneyModel){
    sendMoney.ssn = this.x.getSSN();
    sendMoney.sidentifier = this.x.getIdentifier();
    return <Observable<SendMoneyModel>>this.http.post("http://localhost/dbms/sendMoney", sendMoney, httpOptions);
  }
}
