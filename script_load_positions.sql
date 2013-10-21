/*************************************************************************
Load positions, processed/unprocessed
*************************************************************************/
create database if not exists elle;
use elle;
drop table if exists positions;
create table positions(
	lot_id decimal(6,2) not null,
	line_num tinyint(4) unsigned not null,
	Symbol varchar(24) not null,
	Q decimal(12,4) not null,
	Qori decimal(12,4) not null,
	Lot_Time datetime not null,
	Adj_Price decimal(12,6),
	Adj_Basis decimal(9,2),
	OCE enum('C', 'O', 'E') not null,
	
	Start_Time datetime not null, 
	How enum('A','I','Ex','T','Xfer','o'),
	foreign_id decimal(9,3),		 
	
	Cost_Price decimal(12,6) not null,
	Cost_Basis decimal(9,2) not null,	
	End_Time date,		
	inputLine smallint(5) unsigned not null,
	L_codes varchar(12), 
	
	Codes varchar(12),
	Account enum('IB9048','TOS3622') not null,
	Multi smallint(5) unsigned not null,
	LS enum('L', 'S'),
	SecType enum('O', 'S', 'FX','B','xx') not null,
	
	Underlying varchar(12) not null,
	Expiry date,
	Strike decimal(10,4) unsigned,
	O_Type enum('C', 'P', 'W','o'),
	
	Notes varchar(24),	
	Primary key (lot_id, line_num)
);

Truncate positions;
load data local infile '~/Downloads/pos_processed_130916.csv'
into table positions
fields terminated by ','
lines terminated by '\n'
ignore 1 lines(
lot_id, line_num,
Symbol, Q, Qori, Lot_Time, @Adj_Price, @Adj_Basis, OCE, 
Start_Time, How, foreign_id,
Cost_Price, Cost_Basis, @End_Time, inputLine, @L_codes,
@Codes, Account, Multi, LS, SecType,
Underlying, @Expiry, @Strike, @O_Type, @Notes
)
set
    Adj_Price = if(@Adj_Price = 0, null,@Adj_Price),
    Adj_Basis = if(@Adj_Basis = 0, null,@Adj_Basis),
	End_Time = if(@End_Time  = 0,null,@End_Time),
	L_codes = if(@L_codes= '' ,null,@L_codes),
	Codes  = if(@Codes  = '',null,@Codes), 
	Expiry = if(@Expiry = 0,null,@Expiry),
	Strike = if(@Strike = 0,null,@Strike),
	O_Type = if(@O_Type = '',null,@O_Type),
	Notes = if(@Notes= '' ,null,@Notes);
#select* from positions; 
#673 rows (processed)/673 rows (unprocessed)/684 rows(130914)
