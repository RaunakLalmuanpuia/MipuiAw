<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotes = [
            [ "quote" => "Good governance is the cornerstone of progress and prosperity.", "speaker" => "Kofi Annan" ],
            [ "quote" => "The best form of government is that which is most likely to prevent the greatest sum of evil.", "speaker" => "James Madison" ],
            [ "quote" => "Good governance is about making the right decisions for the long-term benefit of a nation.", "speaker" => "Ellen Johnson Sirleaf" ],
            [ "quote" => "The key to good governance is accountability.", "speaker" => "Atal Bihari Vajpayee" ],
            [ "quote" => "In a democracy, the well-being, individuality, and happiness of every citizen is important for the overall prosperity, peace, and happiness of the nation.", "speaker" => "A. P. J. Abdul Kalam" ],
            [ "quote" => "The price of greatness is responsibility.", "speaker" => "Winston Churchill" ],
            [ "quote" => "Good governance is about transparency, accountability, and effective leadership.", "speaker" => "Shehu Shagari" ],
            [ "quote" => "The art of government is the organization of idolatry.", "speaker" => "George Bernard Shaw" ],
            [ "quote" => "The first and great commandment is: Don't let them scare you.", "speaker" => "Elmer Davis" ],
            [ "quote" => "Government's first duty is to protect the people, not run their lives.", "speaker" => "Ronald Reagan" ],
            [ "quote" => "In the long history of the world, only a few generations have been granted the role of defending freedom in its hour of maximum danger.", "speaker" => "John F. Kennedy" ],
            [ "quote" => "Good governance is the antidote to corruption.", "speaker" => "Luis Inácio Lula da Silva" ],
            [ "quote" => "No nation is fit to sit in judgment upon any other nation.", "speaker" => "Woodrow Wilson" ],
            [ "quote" => "You have to stay true to your heritage; that's what your brand is about.", "speaker" => "Alice Waters" ],
            [ "quote" => "Good governance is about people. It's about making sure that everyone is involved in the process.", "speaker" => "Tony Blair" ],
            [ "quote" => "The more I see of the representatives of the people, the more I admire my dogs.", "speaker" => "Alphonse de Lamartine" ],
            [ "quote" => "Good governance is the lifeblood of any successful organization.", "speaker" => "Mohamad Maliki Osman" ],
            [ "quote" => "The best way to predict the future is to create it.", "speaker" => "Peter Drucker" ],
            [ "quote" => "Good governance means wise leadership, transparency, and accountability.", "speaker" => "George Soros" ],
            [ "quote" => "The best argument I know for an aristocracy is the government of the United States.", "speaker" => "James Russell Lowell" ],
            [ "quote" => "The best argument against democracy is a visit to a government office.", "speaker" => "Winston Churchill" ],
            [ "quote" => "Government is not a solution to our problem; government is the problem.", "speaker" => "Ronald Reagan" ],
            [ "quote" => "The power of imagination makes us infinite", "speaker" => "John Muir" ],
            [ "quote" => "Life is short, and it is up to you to make it sweet", "speaker" => "Sarah Louise Delany" ],
            [ "quote" => "The present moment is the only time over which we have dominion", "speaker" => "Thich Nhat Hanh" ],
            [ "quote" => "Your time is limited, don't waste it living someone else's life", "speaker" => "Steve Jobs" ],
            [ "quote" => "A journey of a thousand miles begins with a single step", "speaker" => "Lao Tzu" ],
            [ "quote" => "Success is not the key to happiness; happiness is the key to success", "speaker" => "Albert Schweitzer" ],
            [ "quote" => "In the dance of life, the rhythm of your heart is the most beautiful melody", "speaker" => "anonymous" ],
            [ "quote" => "Don't count the days; make the days count", "speaker" => "Muhammad Ali" ],
            [ "quote" => "The most important thing is to enjoy your life, to be happy—it's all that matters", "speaker" => "Audrey Hepburn" ],
            [ "quote" => "The only constant in life is change", "speaker" => "anonymous" ],
            [ "quote" => "In the realm of possibilities, imagination is your only limitation", "speaker" => "anonymous" ],
            [ "quote" => "Every day is a new beginning; take a deep breath and start again", "speaker" => "anonymous" ],
            [ "quote" => "Life is a canvas; you are the artist. Paint your dreams and create your reality", "speaker" => "anonymous" ],
            [ "quote" => "Chase your dreams, but always know the road that will lead you home again", "speaker" => "anonymous" ],
            
             

            [ "quote" => "Leadership is not about being in charge. It is about taking care of those in your charge.", "speaker" => "Simon Sinek" ],
            [ "quote" => "Winning doesn't always mean being first. Winning means you're doing better than you've ever done before.", "speaker" => "Bonnie Blair" ],
            [ "quote" => "Patience is not the ability to wait, but the ability to keep a good attitude while waiting.", "speaker" => "Joyce Meyer" ],
            [ "quote" => "A true leader has the confidence to stand alone, the courage to make tough decisions, and the compassion to listen to the needs of others.", "speaker" => "Douglas MacArthur" ],
            [ "quote" => "Winning takes talent, to repeat takes character.", "speaker" => "John Wooden" ],
            [ "quote" => "Patience, persistence, and perspiration make an unbeatable combination for success.", "speaker" => "Napoleon Hill" ],
            [ "quote" => "Leadership is not about being in the spotlight. It's about making others shine.", "speaker" => "Unknown" ],
            [ "quote" => "Winners embrace hard work. They love the discipline of it, the trade-off for continued success.", "speaker" => "Unknown" ],
            [ "quote" => "Patience is the key to contentment and the doorway to success.", "speaker" => "Unknown" ],
            [ "quote" => "Great leaders are willing to sacrifice their own interests for the good of the team.", "speaker" => "John C. Maxwell" ],
            [ "quote" => "To be a winner, all you have to give is all you have.", "speaker" => "Unknown" ],
            [ "quote" => "The two most powerful warriors are patience and time.", "speaker" => "Leo Tolstoy" ],
            [ "quote" => "Winning is not everything, but wanting to win is.", "speaker" => "Vince Lombardi" ],
            [ "quote" => "Patience, when blended with love, wisdom, and a realistic approach, can make the impossible possible.", "speaker" => "Dada J.P. Vaswani" ],
            [ "quote" => "Good leaders inspire people to have confidence in their leader. Great leaders inspire people to have confidence in themselves.", "speaker" => "Eleanor Roosevelt" ],
        ];

    foreach($quotes as $quote){
        Quote::create($quote);
    }
    }

    
}
