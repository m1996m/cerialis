import { Injectable } from '@angular/core';
import { HttpHeaders, HttpClient } from '@angular/common/http';
import { StockModel } from '../Models/stock-model.Model';

@Injectable({
  providedIn: 'root'
})
export class StockService {

  lien = 'http://127.0.0.1:8000/api/';

  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`,
    })
  };

  constructor(private http:HttpClient ) { }

  getAllstock() {
    return this.http.get(this.lien+'stock',this.httpOptions);
  }
  createStock(stock:StockModel) {
    return this.http.post(this.lien+'stock/new',stock,this.httpOptions);
  }

  getSearch(stock:any) {
    return this.http.post(this.lien+'rechercherStock',stock,this.httpOptions);
  }

  getOneStock(id:number){
    return this.http.get(this.lien+'getOneStock/'+id,this.httpOptions);
  }
  editStock(id:number, stock:any){
    return this.http.post(this.lien+'getAndEditStock/'+id,stock,this.httpOptions);
  }
  verificationNom(stock:any){
    return this.http.post(this.lien+'verificationNom',stock,this.httpOptions);
  }
  deleteStock(id:number){
    return this.http.delete(this.lien+'getDeleteStock/'+id,this.httpOptions);
  }
}
