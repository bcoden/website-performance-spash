websiteAnalytics = () => {
    return {
        'quote': '',
        'websiteStatsQuotes': Array(
            "1 in 4 visitors would abandon a website that takes more than 4 seconds to load.",
            "46% of visitors do not revisit a poorly performing website.",
            "A 1 second delay reduces customer satisfaction by 16%"
        ),
        scaffold: function() {
            let getRandomQuote = () => {
                return this.quote = this.websiteStatsQuotes[
                    Math.floor(Math.random() * Math.floor(this.websiteStatsQuotes.length))
                ];
            };
            if (this.websiteStatsQuotes) {
                // based on flag add timer
                this.quote = getRandomQuote();
                setInterval(() => {
                    this.quote = getRandomQuote();
                }, 8000);
            }
        }
    }
};