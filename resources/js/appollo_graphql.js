import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory';
import VueApollo from 'vue-apollo'

let token = document.head.querySelector('meta[name="csrf-token"]')

const httpLink = new HttpLink({
    headers: {
        'X-CSRF-TOKEN': token.content,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    },
    uri: "http://jupiter-satellite-siren.test/graphql"
});

const cache = new InMemoryCache();

// Create the apollo client
const apollo = new ApolloClient({
    link: httpLink,
    cache,
    connectToDevTools: true,
});

const appolloProvider = new VueApollo({
    defaultClient: apollo
});

export default appolloProvider;
