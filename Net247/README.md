# Pasarela Pago - Net 24/7 #

### Pasos para la instalación ###

* Ejecutar "php bin/magento setup:upgrade"
* Verificar en la BD la creación de la tabla "logoscorp_currency_codes"
* Ejecutar el SQL que se encuentra más abajo

#### Configuracione Requeridas ###

* Merchant Id
* API Token
* API URL
* Tender (si el Merchant posee uno)

### Consideraciones ###

* Versión de los codigos ISO correspondientes al 01 Octubre 2021
* Extraidos de la siguiente [enlace](https://www.six-group.com/en/products-services/financial-information/data-standards.html#scrollTo=currency-codes)
* Documentación correspondiente a la API en el siguiente [enlace](https://24-7net.net/api-docs/)

### Script para incluir codigos ISO ###

```
INSERT INTO logoscorp_currency_codes (country_id,currency_id,numeric_code,name)
VALUES
('AF','AFN','971','Afghanistan Afghani'),
('AX','EUR','978','Åland Islands Euro'),
('AL','ALL','008','Albania Lek'),
('DZ','DZD','012','Algerian Dinar'),
('AS','USD','840','American Samoa US Dollar'),
('AD','EUR','978','Andorra Euro'),
('AO','AOA','973','Angola Kwanza'),
('AI','XCD','951','Anguilla East Caribbean Dollar'),
('AG','XCD','951','Antigua and Barbuda East Caribbean Dollar'),
('AR','ARS','032','Argentine Peso'),
('AM','AMD','051','Armenian Dram'),
('AW','AWG','533','Aruban Florin'),
('AU','AUD','036','Australia Dollar'),
('AT','EUR','978','Austria Euro'),
('AZ','AZN','944','Azerbaijan Manat'),
('BS','BSD','044','Bahamian Dollar'),
('BH','BHD','048','Bahraini Dinar'),
('BD','BDT','050','Bangladesh Taka'),
('BB','BBD','052','Barbados Dollar'),
('BY','BYN','933','Belarusian Ruble'),
('BE','EUR','978','Belgium Euro'),
('BZ','BZD','084','Belize Dollar'),
('BJ','XOF','952','Benin CFA Franc BCEAO'),
('BM','BMD','060','Bermudian Dollar'),
('BT','INR','356','Bhutan Indian Rupee'),
('BT','BTN','064','Bhutan Ngultrum'),
('BO','BOB','068','Bolivian Peso'),
('BO','BOV','984','Bolivian Mvdol'),
('BQ','USD','840','Bonaire, Sint Eustatius and Saba US Dollar'),
('BA','BAM','977','Bosnia and Herzegovina Convertible Mark'),
('BW','BWP','072','Botswana Pula'),
('BV','NOK','578','Bouvet Island Norwegian Krone'),
('BR','BRL','986','Brazilian Real'),
('IO','USD','840','British Indian Ocean Territory US Dollar'),
('BN','BND','096','Brunei Darussalam Brunei Dollar'),
('BG','BGN','975','Bulgarian Lev'),
('BF','XOF','952','Burkina Faso CFA Franc BCEAO'),
('BI','BIF','108','Burundi Franc'),
('CV','CVE','132','Cabo Verde Escudo'),
('KH','KHR','116','Cambodia Riel'),
('CM','XAF','950','Cameroon CFA Franc BEAC'),
('CA','CAD','124','Canadian Dollar'),
('KY','KYD','136','Cayman Islands Dollar'),
('CF','XAF','950','Central African Republic CFA Franc BEAC'),
('TD','XAF','950','Chad CFA Franc BEAC'),
('CL','CLP','152','Chilean Peso'),
('CL','CLF','990','Chilean Unidad de Fomento'),
('CN','CNY','156','China Yuan Renminbi'),
('CX','AUD','036','Christmas Island Australian Dollar'),
('CC','AUD','036','Cocos (Keeling) Islands Australian Dollar'),
('CO','COP','170','Colombian Peso'),
('CO','COU','970','Colombian Unidad de Valor Real'),
('KM','KMF','174','Comorian Franc '),
('CD','CDF','976','Congolese Franc'),
('CG','XAF','950','Congo CFA Franc BEAC'),
('CK','NZD','554','Cook Islands New Zealand Dollar'),
('CR','CRC','188','Costa Rican Colon'),
('CI','XOF','952','Côte d''Ivoire CFA Franc BCEAO'),
('HR','HRK','191','Croatia Kuna'),
('CU','CUP','192','Cuban Peso'),
('CU','CUC','931','Cuban Peso Convertible'),
('CW','ANG','532','Curaçao Netherlands Antillean Guilder'),
('CY','EUR','978','Cyprus Euro'),
('CZ','CZK','203','Czech Koruna'),
('DK','DKK','208','Denmark Danish Krone'),
('DJ','DJF','262','Djibouti Franc'),
('DM','XCD','951','Dominica East Caribbean Dollar'),
('DO','DOP','214','Dominican Peso'),
('EC','USD','840','Ecuador US Dollar'),
('EG','EGP','818','Egyptian Pound'),
('SV','SVC','222','El Salvador Colon'),
('SV','USD','840','El Salvador US Dollar'),
('GQ','XAF','950','Equatorial Guinea CFA Franc BEAC'),
('ER','ERN','232','Eritrea Nakfa'),
('EE','EUR','978','Estonia Euro'),
('i	','SZL','748','Lilange'),
('ET','ETB','230','Ethiopia Ethiopian Birr'),
('o	','EUR','978','European Union Eu'),
('FK','FKP','238','Falkland Islands Pound'),
('FO','DKK','208','Faroe Islands Danish Krone'),
('FJ','FJD','242','Fiji Dollar'),
('FI','EUR','978','Finland Euro'),
('FR','EUR','978','France Euro'),
('GF','EUR','978','French Guiana Euro'),
('PF','XPF','953','French Polynesia CFP Franc'),
('TF','EUR','978','French Southern Territories Euro'),
('GA','XAF','950','Gabon CFA Franc BEAC'),
('GM','GMD','270','Gambia Dalasi'),
('GE','GEL','981','Georgia Lari'),
('DE','EUR','978','Germany Euro'),
('GH','GHS','936','Ghana Cedi'),
('GI','GIP','292','Gibraltar Pound'),
('GR','EUR','978','Greece Euro'),
('GL','DKK','208','Greenland Danish Krone'),
('GD','XCD','951','Grenada East Caribbean Dollar'),
('GP','EUR','978','Guadeloupe Euro'),
('GU','USD','840','Guam US Dollar'),
('GT','GTQ','320','Guatemala Quetzal'),
('GG','GBP','826','Guernsey Pound Sterling'),
('GN','GNF','324','Guinea Franc'),
('GW','XOF','952','Guinea-Bissau CFA Franc BCEAO'),
('GY','GYD','328','Guyana Dollar'),
('HT','HTG','332','Haiti Gourde'),
('HT','USD','840','Haiti US Dollar'),
('HM','AUD','036','Heard Island and McDonald Islands Australian Dollar'),
('VA','EUR','978','Holy See (Vatican City State) Euro'),
('HN','HNL','340','Honduras Lempira'),
('HK','HKD','344','Hong Kong Dollar'),
('HU','HUF','348','Hungary Forint'),
('IS','ISK','352','Iceland Krona'),
('IN','INR','356','India Rupee'),
('ID','IDR','360','Indonesia Rupiah'),
(')	','XDR','960','SDR (Special Drawing Righ'),
('IR','IRR','364','Iranian Rial'),
('IQ','IQD','368','Iraqi Dinar'),
('IE','EUR','978','Ireland Euro'),
('IM','GBP','826','Isle of Man Pound Sterling'),
('IL','ILS','376','Israeli Sheqel'),
('IT','EUR','978','Italy Euro'),
('JM','JMD','388','Jamaican Dollar'),
('JP','JPY','392','Japan Yen'),
('JE','GBP','826','Jersey Pound Sterling'),
('JO','JOD','400','Jordanian Dinar'),
('KZ','KZT','398','Kazakhstan Tenge'),
('KE','KES','404','Kenyan Shilling'),
('KI','AUD','036','Kiribati Australian Dollar'),
('KP','KPW','408','North Korean Won'),
('KR','KRW','410','Korea Won'),
('KW','KWD','414','Kuwaiti Dinar'),
('KG','KGS','417','Kyrgyzstan Som'),
('LA','LAK','418','Lao Kip'),
('LV','EUR','978','Latvia Euro'),
('LB','LBP','422','Lebanese Pound'),
('LS','LSL','426','Lesotho Loti'),
('LS','ZAR','710','Lesotho Rand'),
('LR','LRD','430','Liberian Dollar'),
('LY','LYD','434','Libyan Dinar'),
('LI','CHF','756','Liechtenstein Swiss Franc'),
('LT','EUR','978','Lithuania Euro'),
('LU','EUR','978','Luxembourg Euro'),
('MO','MOP','446','Macao Pataca'),
('MK','MKD','807','Macedonia Denar'),
('MG','MGA','969','Malagasy Ariary'),
('MW','MWK','454','Malawi Kwacha'),
('MY','MYR','458','Malaysian Ringgit'),
('MV','MVR','462','Maldives Rufiyaa'),
('ML','XOF','952','Mali CFA Franc BCEAO'),
('MT','EUR','978','Malta Euro'),
('MH','USD','840','Marshall Islands US Dollar'),
('MQ','EUR','978','Martinique Euro'),
('MR','MRU','929','Mauritania Ouguiya'),
('MU','MUR','480','Mauritius Rupee'),
('YT','EUR','978','Mayotte Euro'),
('t	','XUA','965','ADB Unit of Accou'),
('MX','MXN','484','Mexican Peso'),
('MX','MXV','979','Mexican Unidad de Inversion (UDI)'),
('FM','USD','840','Federated States of Micronesia US Dollar'),
('MD','MDL','498','Moldovan Leu'),
('MC','EUR','978','Monaco Euro'),
('MN','MNT','496','Mongolia Tugrik'),
('ME','EUR','978','Montenegro Euro'),
('MS','XCD','951','Montserrat East Caribbean Dollar'),
('MA','MAD','504','Moroccan Dirham'),
('MZ','MZN','943','Mozambique Metical'),
('MM','MMK','104','Myanmar Kyat'),
('NA','NAD','516','Namibia Dollar'),
('NA','ZAR','710','Namibia Rand'),
('NR','AUD','036','Nauru Australian Dollar'),
('NP','NPR','524','Nepal Nepalese Rupee'),
('NL','EUR','978','Netherlands Euro'),
('NC','XPF','953','New Caledonia CFP Franc'),
('NZ','NZD','554','New Zealand Dollar'),
('NI','NIO','558','Nicaragua Cordoba Oro'),
('NE','XOF','952','Niger CFA Franc BCEAO'),
('NG','NGN','566','Nigeria Naira'),
('NU','NZD','554','Niue New Zealand Dollar'),
('NF','AUD','036','Norfolk Island Australian Dollar'),
('MP','USD','840','Northern Mariana Islands US Dollar'),
('NO','NOK','578','Norway Krone'),
('OM','OMR','512','Oman Rial Omani'),
('PK','PKR','586','Pakistan Rupee'),
('PW','USD','840','Palau US Dollar'),
('PA','PAB','590','Panama Balboa'),
('PA','USD','840','Panama US Dollar'),
('PG','PGK','598','Papua New Guinea Kina'),
('PY','PYG','600','Paraguay Guarani'),
('PE','PEN','604','Peru Sol'),
('PH','PHP','608','Philippine Peso'),
('PN','NZD','554','Pitcairn New Zealand Dollar'),
('PL','PLN','985','Poland Zloty'),
('PT','EUR','978','Portugal Euro'),
('PR','USD','840','Puerto Rico US Dollar'),
('QA','QAR','634','Qatari Rial'),
('RE','EUR','978','Réunion Euro'),
('RO','RON','946','Romanian Leu'),
('RU','RUB','643','Russian Ruble'),
('RW','RWF','646','Rwanda Franc'),
('BL','EUR','978','Saint Barthélemy Euro'),
('SH','SHP','654','Saint Helena Pound'),
('KN','XCD','951','Saint Kitts and Nevis East Caribbean Dollar'),
('LC','XCD','951','Saint Lucia East Caribbean Dollar'),
('MF','EUR','978','Saint Martin (French part) Euro'),
('PM','EUR','978','Saint Pierre and Miquelon Euro'),
('VC','XCD','951','Saint Vincent and the Grenadines East Caribbean Dollar'),
('WS','WST','882','Samoa Tala'),
('SM','EUR','978','San Marino Euro'),
('ST','STN','930','Sao Tome and Principe Dobra'),
('SA','SAR','682','Saudi Riyal'),
('SN','XOF','952','Senegal CFA Franc BCEAO'),
('RS','RSD','941','Serbian Dinar'),
('SC','SCR','690','Seychelles Rupee'),
('SL','SLL','694','Sierra Leone'),
('SG','SGD','702','Singapore Dollar'),
('SX','ANG','532','Sint Maarten (Dutch part) Netherlands Antillean Guilder'),
('e	','XSU','994','Suc'),
('SK','EUR','978','Slovakia Euro'),
('SI','EUR','978','Slovenia Euro'),
('SB','SBD','090','Solomon Islands Dollar'),
('SO','SOS','706','Somali Shilling'),
('ZA','ZAR','710','South Africa Rand'),
('SS','SSP','728','South Sudanese Pound'),
('ES','EUR','978','Spain Euro'),
('LK','LKR','144','Sri Lanka Rupee'),
('SD','SDG','938','Sudanese Pound'),
('SR','SRD','968','Surinam Dollar'),
('SJ','NOK','578','Svalbard and Jan Mayen Norwegian Krone'),
('SE','SEK','752','Swedish Krona'),
('CH','CHF','756','Switzerland Swiss Franc'),
('CH','CHE','947','Switzerland WIR Euro'),
('CH','CHW','948','Switzerland WIR Franc'),
('SY','SYP','760','Syrian Pound'),
('TW','TWD','901','Taiwan Dollar'),
('TJ','TJS','972','Tajikistan Somoni'),
('TZ','TZS','834','Tanzanian Shilling'),
('TH','THB','764','Thailand Baht'),
('TL','USD','840','Timor-Leste US Dollar'),
('TG','XOF','952','Togo CFA Franc BCEAO'),
('TK','NZD','554','Tokelau New Zealand Dollar'),
('TO','TOP','776','Tonga Pa’anga'),
('TT','TTD','780','Trinidad and Tobago Dollar'),
('TN','TND','788','Tunisian Dinar'),
('TR','TRY','949','Turkish Lira'),
('TM','TMT','934','Turkmenistan New Manat'),
('TC','USD','840','Turks and Caicos Islands US Dollar'),
('TV','AUD','036','Tuvalu Australian Dollar'),
('UG','UGX','800','Uganda Shilling'),
('UA','UAH','980','Ukraine Hryvnia'),
('AE','AED','784','United Arab Emirates UAE Dirham'),
('GB','GBP','826','United Kingdom Pound Sterling'),
('UM','USD','840','United States Minor Outlying Islands US Dollar'),
('US','USD','840','United States US Dollar'),
('US','USN','997','United States US Dollar (Next day)'),
('UY','UYU','858','Uruguay Peso'),
('UY','UYI','940','Uruguay Peso en Unidades Indexadas (UI)'),
('UY','UYW','927','Uruguay Unidad Previsional'),
('UZ','UZS','860','Uzbekistan Sum'),
('VU','VUV','548','Vanuatu Vatu'),
('VE','VES','928','Venezuela Bolívar Soberano'),
('VE','VED','926','Venezuela Bolívar Digital'),
('VN','VND','704','Viet Nam Dong'),
('VG','USD','840','Virgin Islands, British US Dollar'),
('VI','USD','840','Virgin Islands, U.S. US Dollar'),
('WF','XPF','953','Wallis and Futuna CFP Franc'),
('EH','MAD','504','Western Sahara Moroccan Dirham'),
('YE','YER','886','Yemeni Rial'),
('ZM','ZMW','967','Zambian Kwacha'),
('ZW','ZWL','932','Zimbabwe Dollar');
```