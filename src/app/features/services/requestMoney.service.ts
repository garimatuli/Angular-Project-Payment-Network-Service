import { Injectable } from '@angular/core';

import {Observable, of} from 'rxjs';
import {HttpResponse, HttpHeaders} from "@angular/common/http";
import { HttpClient } from "@angular/common/http";

import {UserInfoService} from "../../services/user-info.service";
import {RequestMoneyModel} from "../models/requestMoney.model";


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

export class requestMoneyService {

  constructor(private http: HttpClient, private x: UserInfoService) { }

  getProfileBalance(){
    let currentSSN = this.x.getSSN();
    return <Observable<any>> this.http.get("http://localhost/dbms/getBalance?ssn="+currentSSN);
  }

  postRequestMoney(requestMoney:RequestMoneyModel){
    requestMoney.ssn = this.x.getSSN();
    requestMoney.ridentifier = this.x.getIdentifier();
    return <Observable<RequestMoneyModel>>this.http.post("http://localhost/dbms/requestMoney", requestMoney, httpOptions);
  }
}
