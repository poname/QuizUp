var config = {};

config.backendHost = 'localhost';
config.backendPort = 80;
config.baseUri = '/qp';
config.backendUri = 'http://'+config.backendHost+config.baseUri;

config.apiPath = '/api';
config.waitInterval = 10000;


module.exports = config;