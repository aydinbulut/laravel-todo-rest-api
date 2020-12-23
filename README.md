# API & CLIENT PROJECTS

The APPs are located in `src/` directory. In the root, docker related files are located.

## GET STARTED 

If you have `Makefile` on your host machine you can use make commands mentioned in this README, otherwise you need to 
use relevant original commands. You need to run make command from the root of the project.

To start Docker environment 

`make env-start`

### API

The API application provides an OpenAPI documentation. Once the Docker environment is up, visit 
[http://localhost](http://localhost). You can see request and response structures and run the endpoints.

#### API Setup

You can use following commands;

`make api-migrate`: Migrate the database   
`make api-seed`: Seed(populate) the database with fake data    
`make api-migrate-seed`: Combination of above 2 methods

### CLIENT

Client application written with ReactJs with Typescript template.

#### Client Setup

You can use following commands;

`make client-install`: Install the dependencies  
`make client-start`: Start the client application  

###### Help

To see all options, run: 

`make`
