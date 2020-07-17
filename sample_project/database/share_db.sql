-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2020 at 09:20 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `share_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `registration_id`, `added_by`, `creation_time`) VALUES
(11, 51, '51', '2020-04-17 18:04:42'),
(30, 81, '51', '2020-04-18 17:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blocked_story`
--

CREATE TABLE `tbl_blocked_story` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `blocked_by` int(11) NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blocked_user`
--

CREATE TABLE `tbl_blocked_user` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `blocked_by` int(11) NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_body` mediumtext NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment_time` datetime NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`comment_id`, `comment_body`, `comment_by`, `comment_time`, `post_id`) VALUES
(39, 'this story is informative.thank you for sharing', 80, '2020-04-18 05:42:49', 62),
(40, 'i do traveling all the time.i do like these 4 star hotels.Thank you for this informative post', 51, '2020-04-18 17:17:34', 70),
(41, 'Sokha Hotels is beautiful', 51, '2020-04-18 17:28:27', 70),
(42, 'Great post', 51, '2020-04-18 21:00:46', 71),
(43, 'very helpfull', 51, '2020-04-18 21:00:53', 71),
(44, 'nice post', 83, '2020-06-11 13:59:26', 72);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registration`
--

CREATE TABLE `tbl_registration` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` int(11) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(2) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(200) NOT NULL,
  `creationTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_registration`
--

INSERT INTO `tbl_registration` (`id`, `name`, `email`, `phone`, `birthday`, `gender`, `password`, `image`, `creationTime`) VALUES
(51, 'Md. Motiur Rahman', 'anublar.rony@gmail.com', 1679118554, '2020-04-04', 'M', '$2y$10$LeGTc1o5Fp/TpP5cqvmxNO9VL0dfHnv5u4nR38C37pPjxomMUivQS', './pro_image/855.jpg', '2020-05-28 01:14:02'),
(81, 'shafiqur Rahman', 'shafiqur@gmail.com', 1712076120, '1969-06-28', 'M', '$2y$10$PSwDGK6ALte55EFFke9ALuKDS/mdL/2B.QTsx/K5qAi8p3ihaITcm', './pro_image/175.png', '2020-04-18 16:55:22'),
(82, 'jonathan', 'jonathan@gmail.com', 1716519801, '1989-03-04', 'M', '$2y$10$qsNvAtDzlenQVTtBMfyI.OvBL.GfyDJ0AQwU5mmnuSgBWIc2hiIQy', './pro_image/629.jpg', '2020-04-18 20:30:13'),
(83, 'ahmed', 'aaaa@gmail.com', 1711004488, '2010-03-01', 'M', '$2y$10$GhjfUOg7qOh8VMkd6A7UWObEc9EUPkxZG0ZaHDFhhdRLjipw9uuNG', './pro_image/442.jpg', '2020-06-11 13:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL,
  `sectionName` varchar(200) NOT NULL,
  `addedBy` varchar(100) NOT NULL,
  `creationTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`id`, `sectionName`, `addedBy`, `creationTime`) VALUES
(23, 'Dummy text', 'anublar.rony@gmail.com', '2020-04-18 05:25:23'),
(24, 'Food', 'anublar.rony@gmail.com', '2020-04-18 15:10:38'),
(25, 'Travel', 'anublar.rony@gmail.com', '2020-04-18 15:23:24'),
(26, 'Diet', 'anublar.rony@gmail.com', '2020-04-18 15:54:07'),
(27, 'habit', 'anublar.rony@gmail.com', '2020-04-18 20:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_story`
--

CREATE TABLE `tbl_story` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `creationTime` datetime NOT NULL,
  `section_id` int(11) NOT NULL,
  `blocked_flag` int(11) NOT NULL,
  `blocked_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_story`
--

INSERT INTO `tbl_story` (`id`, `title`, `body`, `user_id`, `creationTime`, `section_id`, `blocked_flag`, `blocked_by`) VALUES
(62, 'Lorem Ipsum', '<h2>What is Lorem Ipsum?</h2>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"150\" sizes=\"Alone in the field\" src=\"https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80\" width=\"120\" />\n<figcaption>Alone boy</figcaption>\n</figure>\n\n<p>remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n\n<h2>Why do we use it?</h2>\n\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\n\n<p>Caption</p>\n\n<p>&nbsp;</p>\n\n<h2>Where does it come from?</h2>\n\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\n\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n\n<h2>Where can I get some?</h2>\n\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"173\" src=\"http://umhistory.dc.umich.edu/mort/central/north%20of%20north%20u/Rackham%20Graduate%20School/images/new_hi_res/02-Horace-Rackham.jpg\" width=\"80\" />\n<figcaption>H. Rackham</figcaption>\n</figure>\n\n<p>Caption</p>\n\n<h3>1914 translation by H. Rackham</h3>\n\n<p>&quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying</p>\n\n<p>consequences, or one who avoids a pain that produces no resultant pleasure?&quot;&nbsp;</p>', 51, '2020-04-18 07:34:40', 23, 0, 0),
(66, 'Why We Love Food Network', '<p>Whenever I hear someone say they hate television it amazes me. My next question is always &ldquo;what do you watch?&rdquo; I never seem to get a straight answer. With the advent of cable television and satellite tv, there is always something on.</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"200\" src=\"https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=1&amp;w=500\" width=\"300\" />\n<figcaption>Caption: Popular dish</figcaption>\n</figure>\n\n<figure class=\"image\" style=\"float:left\"><img alt=\"\" height=\"200\" src=\"https://image.shutterstock.com/image-photo/healthy-food-clean-eating-selection-260nw-722718082.jpg\" />\n<figcaption>Caption:Popular ingredients</figcaption>\n</figure>\n\n<p>For food lovers, food network has to be the best thing on television since Julia Child was on the air. Between the celebrities that do the cooking, and the topics and recipes that they pick, what else could you ask for. It really was an ingenious concept, a food channel that is on 24 hour a day all about food. It is even a better fit than the golf channel, or the history channel or any other channel because everyone eats.</p>\n\n<p>Once you add the personalities of the &ldquo;Celebrity Chefs&rdquo; to the shows, you can only have a winning formula. Rachael Ray is definitely my favorite, it seems as if, just like all of the chefs that she is always in a great mood, which is always refreshing. Then there&rsquo;s Emeril, who must be the most popular, has combined an open forum with music and celebrity guests. For Emeril to be the standout for food network makes perfect sense, his knowledge of food is unbelievable, he is very easy to like for men and women, and he likes to have fun. It&rsquo;s almost as if you&rsquo;re in his house while he&rsquo;s cooking</p>\n\n<p>I don&rsquo;t think that I have ever watched Alton Brown&rsquo;s Good Eats, and not learned something. His information is a lot of did you know, that you probably did not know. Paula Dean&rsquo;s southern style is always warm and friendly. There is a show everyone, which should be the goal of all television networks</p>\n\n<p>Food network was a very welcome addition to cable tv land, with the technology of digital cable and tivo, you can have all your favorite shows ready to watch whenever you want. Can you imagine back in the day being able to watch Julia Child whenever you want?</p>\n\n<p>Another reason we love food network is their website. It is very informative and anything you see on television you can get from their website. Everything from the recipes that you see, to the actual video. It is pretty easy to navigate and find what you are looking for. Their online store has everything from cookbooks to cooking utensils. With food network becoming more and more popular, we can only hope that it grows and expands to cover more topics and foods.</p>\n\n<p>&nbsp;</p>', 51, '2020-04-18 15:15:40', 24, 0, 0),
(67, '4 Star Hotels', '<p>Everyone wants to go on a nice, relaxing, and quiet vacation every once in a while, but not everyone has the kind of money that can buy a 5-star hotel stay for the weekend. In that once every few years chance that you have saved just enough for a lush weekend trip, you have the choice to go all out on a first rate hotel and have little left for going around town, or to pick a more reasonably priced 4 star hotel and still have a good budget for seeing the best that the hotel&rsquo;s surroundings has to offer.</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"194\" src=\"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTd0JevZimaxFEwIEjb1wBWciGGeb7Er7Om57BoA1J1manZHCaZ&amp;usqp=CAU\" width=\"259\" />\n<figcaption>Caption:Novotel Solo Hotel</figcaption>\n</figure>\n\n<p>No matter what popular tourist destination you go to, there are 4-star hotels that are more than capable of competing with the first class hotels in the same town. Despite the difference in ratings, it is possible that the only disparity that counts between 4-star hotels and their 5-star counterparts is the price range, especially if you&rsquo;re one customer who is only slightly particular about the kind and range of services offered in the hotel you choose to stay in. Some 4-star hotels even offer a wider range of amenities than some 5-star hotels at a lower price. Also, some 4 star hotels are considered the best in a certain region, as a 4-star rating is the highest for the hotel grading body ruling that area.</p>\n\n<p>However, notice that the prices also differ according to the hotels&rsquo; respective distances from the center of the city or town; the prices reduce as the location moves farther from the center. The factor of how much of the city center you want to see should therefore play a role in planning your luxurious weekend getaway. After all, what you save in accommodations could easily turn into expenses when you need to spend more on transportation between the hotel and tourist spots you intend to visit.</p>\n\n<p>Four-star hotels are also suitable for business travel, as business centers and conference halls are available in most. The business traveler can also benefit from the luxurious service a 4-star hotel offers, as the hotel can easily cater to a mix of business and pleasure. Some can even be a source of inspiration and tranquility, particularly those with extra provisions for privacy, such as soundproofed rooms, and wellness facilities, such as room massage service and a Zen garden.</p>\n\n<p>Here&rsquo;s a list of 4 star hotels that may be worth spending a weekend in someday: the Sofitel Paris Porte de Sevres, which also offers wireless Internet access in some rooms, 3 restaurants catering to different tastes, and the option to stay on one of its eight non-smoking floors; the Hotel Forum in Rome, with a roof-garden restaurant overlooking the Venice Square and the Colosseum; and the Elite Hotel Praha in Prague, which is located in a quiet, yet scenic part of town, and features a day bar with a small leisure garden and a grill club that showcases the best of French, Argentinian and Spanish cuisines.</p>', 51, '2020-04-18 15:24:23', 25, 0, 0),
(68, 'V-egg-ie Good for You', '<p>According to the latest U.S. Dietary Guidelines, adults and children alike should have from 5 to 13 servings of fruits and veggies a day, each serving at least 1/2 cup. While this is beyond what most people currently consume, it&rsquo;s not an impossible task. For veggies, simply include them with foods you and your family already like.</p>\n\n<p>In general, you need to eat a wide variety of vegetables, including plenty of the bright- and deep-colored ones, to get all the vitamins, minerals and fiber that veggies have to offer. With the exception of soy foods, though, the protein in plant foods is incomplete. It lacks one or more of the protein building blocks that your body can&rsquo;t make.</p>\n\n<p>You can mix and match different plant foods to make their protein complete. But even many vegetarians find that it&rsquo;s easier to simply include a complete protein source, such as eggs or milk foods, in their meals. Nutrient-dense eggs provide not only some of the highest quality protein available but, except for vitamin C, eggs also contain varying amounts of all the essential vitamins, including those that are not abundant in plant foods.</p>\n\n<p>It&rsquo;s simple to combine eggs and veggies in satisfying entrees. For instance, you can turn a salad into a quick-fix main dish by starting with greens -; the darker green, the better nutrient content. Toss with other vegetables, perhaps whatever is coming up in your home garden or is most appealing at the store. Then, top with wedged, sliced or chopped eggs to add the protein you need. Finish the unique salad off with a hurry-up, homemade hot dressing. This salad is especially easy to make if you keep a dozen hard-cooked eggs chilled in the fridge. You can store the eggs for a week after cooking and use them for handy snacks, too.</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"225\" src=\"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQwC29jgLqmU1tsvVswHNCLIk6QJpXRTMqlYe2reo6hL6LirNqa&amp;usqp=CAU\" width=\"225\" />\n<figcaption>Caption:roasted-veggie-quinoa-bowl</figcaption>\n</figure>\n\n<p>Warm Mimosa Salad</p>\n\n<p>6 servings</p>\n\n<p>6 cups loosely packed, torn mixed greens (about 9 oz.)</p>\n\n<p>6 hard-cooked eggs, chopped</p>\n\n<p>2 small or 1 medium zucchini, cut into julienne strips (about 2 to 2 1/2 cups)</p>\n\n<p>1 cup thinly sliced onion (about 1 medium)</p>\n\n<p>2 tablespoons cooking oil</p>\n\n<p>2/3 cup red wine vinegar</p>\n\n<p>1 1/2 tablespoons Dijon mustard</p>\n\n<p>1 1/2 teaspoons Italian seasoning, crushed</p>\n\n<p>1 teaspoon sugar</p>\n\n<p>1/2 teaspoon garlic powder</p>\n\n<p>1 large tomato, wedged (about 7 to 8 oz.)</p>\n\n<p>Tear greens into large bowl. Add eggs. Set aside. In 10-inch skillet or large saucepan over medium heat, cook zucchini and onion in hot oil, stirring occasionally, until crisp-tender, about 4 to 5 minutes. In small bowl, stir together vinegar, mustard, seasoning, sugar and garlic powder. Pour over vegetables in skillet. Stir in tomato and cook until heated through, about 1 minute more. Pour over reserved greens. Gently toss until evenly coated with dressing. Serve immediately.</p>\n\n<p>Nutrition information per serving of 1/6 recipe using romaine, leaf lettuce and corn oil: 162 calories, 10 gm total fat, 213 mg cholesterol, 165 mg sodium, 448 mg potassium, 9 gm carbohydrate, 8 gm protein and 10% or more of the RDI for vitamins A and C, riboflavin, phosphorus</p>', 51, '2020-04-18 15:29:37', 24, 0, 0),
(69, 'Foods need to eat for healthy life', '<h2>What is a healthy diet?</h2>\n\n<p>Eating a healthy diet is not about strict limitations, staying unrealistically thin, or depriving yourself of the foods you love. Rather, it&rsquo;s about feeling great, having more energy, improving your health, and boosting your mood.</p>\n\n<p>Healthy eating doesn&rsquo;t have to be overly complicated. If you feel overwhelmed by all the conflicting nutrition and diet advice out there, you&rsquo;re not alone. It seems that for every expert who tells you a certain food is good for you, you&rsquo;ll find another saying exactly the opposite. The truth is that while some specific foods or nutrients have been shown to have a beneficial effect on mood, it&rsquo;s your overall dietary pattern that is most important. The cornerstone of a healthy diet should be to replace processed food with real food whenever possible. Eating food that is as close as possible to the way nature made it can make a huge difference to the way you think, look, and feel.</p>\n\n<p>By using these simple tips, you can cut through the confusion and learn how to create&mdash;and stick to&mdash;a tasty, varied, and nutritious diet that is as good for your mind as it is for your body.</p>\n\n<h3>The Healthy Eating Pyramid</h3>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"Healthy eating pyramid\" height=\"200\" src=\"https://www.helpguide.org/wp-content/uploads/2018/11/healthy-eating-pyramid-350.jpg\" width=\"212\" />\n<figcaption>Caption:Diet chart</figcaption>\n</figure>\n\n<p>The Harvard Healthy Eating Pyramid represents the latest nutritional science. The widest part at the bottom is for things that are most important. The foods at the narrow top are those that should be eaten sparingly, if at all.</p>\n\n<h2>The fundamentals of healthy eating</h2>\n\n<p>While some extreme diets may suggest otherwise, we all need a balance of protein, fat, carbohydrates, fiber, vitamins, and minerals in our diets to sustain a healthy body. You don&rsquo;t need to eliminate certain categories of food from your diet, but rather select the healthiest options from each category.</p>\n\n<p><strong>Protein</strong>&nbsp;gives you the energy to get up and go&mdash;and keep going&mdash;while also supporting mood and cognitive function. Too much protein can be harmful to people with kidney disease, but the latest research suggests that many of us need more high-quality protein, especially as we age. That doesn&rsquo;t mean you have to eat more animal products&mdash;a variety of plant-based sources of protein each day can ensure your body gets all the essential protein it needs.&nbsp;<a href=\"https://www.helpguide.org/articles/healthy-eating/choosing-healthy-protein.htm\">Learn more &raquo;</a></p>\n\n<p><strong>Fat</strong>. Not all fat is the same. While bad fats can wreck your diet and increase your risk of certain diseases, good fats protect your brain and heart. In fact, healthy fats&mdash;such as omega-3s&mdash;are vital to your physical and emotional health. Including more healthy fat in your diet can help improve your mood, boost your well-being, and even trim your waistline.&nbsp;<a href=\"https://www.helpguide.org/articles/healthy-eating/choosing-healthy-fats.htm\">Learn more &raquo;</a></p>\n\n<p><strong>Fiber</strong>. Eating foods high in dietary fiber (grains, fruit, vegetables, nuts, and beans) can help you stay regular and lower your risk for heart disease, stroke, and diabetes. It can also improve your skin and even help you to lose weight.</p>', 51, '2020-04-18 15:54:35', 26, 0, 0),
(70, 'Four-Star Hote', '<p>The Forbes, formerly Mobil,&nbsp;<a href=\"http://i.viglink.com/?key=61b366eca462f79ffdc8582e414718ce&amp;insertId=06ed721beb0e4621&amp;type=S&amp;exp=60%3ACI1C55A%3A12&amp;libId=k95ianpm01021lkz000DLbg8tb8f2&amp;loc=https%3A%2F%2Ftraveltips.usatoday.com%2Ffour-star-hotel-definition-21425.html&amp;v=1&amp;iid=06ed721beb0e4621&amp;opt=true&amp;out=http%3A%2F%2Fwww.amazon.com%2Fgp%2Fsearch%3Fie%3DUTF8%26camp%3D1789%26creative%3D9325%26index%3Daps%26keywords%3Dtravel%252Bguide%26linkCode%3Dur2&amp;ref=https%3A%2F%2Fwww.google.com%2F&amp;title=Four-Star%20Hotel%20Definition%20%7C%20USA%20Today&amp;txt=%3Cspan%3ETravel%20%3C%2Fspan%3E%3Cspan%3EGuide%3C%2Fspan%3E\" target=\"_blank\">Travel&nbsp;Guide</a>&nbsp;has used a star system to rank hotels since 1958. Many travel websites have their own star rating systems, offering little consistency from site to site, but the Forbes/Mobil ratings use well-established criteria.</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"183\" src=\"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRNi-VTOOHsiHMeR1pUUu_JZRLyBR30-tSeefKZw0nyt1Bb24tx&amp;usqp=CAU\" width=\"275\" />\n<figcaption>Caption:Sokha Hotels &amp; Resorts</figcaption>\n</figure>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>\n\n<h2>Service</h2>\n\n<p>Service is all-important at Mobil four- and&nbsp;five-star hotels. The staff is judged on courtesy, knowledge, efficiency, promptness, comportment and anticipation of guests&#39; needs.</p>\n\n<h2>Beds</h2>\n\n<p>Beds have high-quality linens, including either washable duvets or triple sheeting. Pillows are luxurious and numerous. Turndown service is provided.</p>\n\n<h2>Bathrooms</h2>\n\n<p>Showers do not have plastic curtains, and fine toiletries are beautifully displayed. The space is more than adequate for two people, with plenty of storage.&nbsp;Robes&nbsp;and towels are plush.</p>\n\n<h2>Dining</h2>\n\n<p>An on-site restaurant offers a full breakfast, lunch and dinner menu. Room service arrives within 30 minutes, and within five minutes of the promised&nbsp;<a href=\"http://i.viglink.com/?key=61b366eca462f79ffdc8582e414718ce&amp;insertId=605d571f92e72b51&amp;type=H&amp;exp=60%3ACI1C55A%3A12&amp;libId=k95ianpm01021lkz000DLbg8tb8f2&amp;loc=https%3A%2F%2Ftraveltips.usatoday.com%2Ffour-star-hotel-definition-21425.html&amp;v=1&amp;iid=605d571f92e72b51&amp;opt=true&amp;out=https%3A%2F%2Fwww.amazon.com%2Fdp%2FB07B7M6KVQ&amp;ref=https%3A%2F%2Fwww.google.com%2F&amp;title=Four-Star%20Hotel%20Definition%20%7C%20USA%20Today&amp;txt=%3Cspan%3Edelivery%20%3C%2Fspan%3E%3Cspan%3Etime%3C%2Fspan%3E\" target=\"_blank\">delivery&nbsp;time</a>.</p>\n\n<h2>Hotel Amenities</h2>\n\n<p>A four-star hotel offers a fitness center with televisions. It has a concierge desk and at least two complimentary newspapers for guests. Same-day laundry or dry cleaning service is available. The lobby and public restrooms are richly appointed, with fresh flowers or live plants.</p>\n\n<p>DISCLOSURE</p>\n\n<p>Leaf Group is a USA TODAY content partner providing general travel information. Its content is produced independently of USA TODAY.</p>\n\n<p>&nbsp;</p>', 81, '2020-04-18 16:59:51', 25, 1, 51),
(71, 'How to Make Your Future Habits Easy', '<figure class=\"image\" style=\"float:right\"><img alt=\"\" height=\"150\" src=\"https://i.pinimg.com/originals/d9/3f/60/d93f6090f5cd33940b8c0e06ca5c6d80.jpg\" width=\"267\" />\n<figcaption>Caption:Good habits</figcaption>\n</figure>\n\n<p><em>&nbsp;This article is an excerpt from&nbsp;<a href=\"https://jamesclear.com/atomic-habits\">Atomic Habits</a>, my New York Times bestselling book.</em></p>\n\n<p>While researching&nbsp;<a href=\"http://atomichabits.com/\" target=\"_blank\">Atomic Habits</a>, I came across a story that immediately struck me with its simplicity and power. It was the story of Oswald Nuckols, an IT developer from Natchez, Mississippi, and his simple strategy for making future habits easy.</p>\n\n<p>Nuckols refers to the approach as &ldquo;resetting the room.&rdquo;</p>\n\n<p>For instance, when he finishes watching television, he places the remote back on the TV stand, arranges the pillows on the couch, and folds the blanket. When he leaves his car, he throws any trash away. Whenever he takes a shower, he wipes down the toilet while the shower is warming up. (As he notes, the &ldquo;perfect time to clean the toilet is right before you wash yourself in the shower anyway.&rdquo;)</p>\n\n<figure class=\"image\" style=\"float:left\"><img alt=\"\" height=\"150\" src=\"https://i.ytimg.com/vi/McVQ-ssbib8/sddefault.jpg\" width=\"200\" />\n<figcaption>Caption:good habits</figcaption>\n</figure>\n\n<p>This might sound like he&#39;s just &ldquo;cleaning up&rdquo; but there is a key insight that makes his approach different. The purpose of resetting each room is not simply to clean up after the last action, but to prepare for the next action.</p>\n\n<p>&ldquo;When I walk into a room everything is in its right place,&rdquo; Nuckols wrote. &ldquo;Because I do this every day in every room, stuff always stays in good shape&nbsp;.&nbsp;.&nbsp;. People think I work hard but I&rsquo;m actually really lazy. I&rsquo;m just proactively lazy. It gives you so much time back.&rdquo;</p>\n\n<p>I have written previously about&nbsp;<a href=\"https://jamesclear.com/power-of-environment\">the power of the environment to shape your behavior</a>. Resetting the room is one way to put the power back in your own hands. Let&#39;s talk about how you can use it.</p>\n\n<h2>The Power of Priming the Environment</h2>\n\n<p>Whenever you organize a space for its intended purpose, you are priming it to make the next action easy. This is one of the most practical and simple ways to improve your habits.</p>\n\n<p>For instance, my wife keeps a box of greeting cards that are presorted by occasion&mdash;birthday, sympathy, wedding, graduation, and more. Whenever necessary, she grabs an appropriate card and sends it off. She is incredibly good at remembering to send cards because she has reduced the friction of doing so.</p>\n\n<p>For years, I was the opposite. Someone would have a baby and I would think, &ldquo;I should send a card.&rdquo; But then weeks would pass and by the time I remembered to pick one up at the store, it was too late. The habit wasn&rsquo;t easy.</p>\n\n<p>There are many ways to prime your environment so it&rsquo;s ready for immediate use. If you want to cook a healthy breakfast, place the skillet on the stove, set the cooking spray on the counter, and lay out any plates and utensils you&rsquo;ll need the night before. When you wake up, making breakfast will be easy.</p>\n\n<p>Here are some more:</p>\n\n<ul>\n	<li>Want to draw more? Put your pencils, pens, notebooks, and drawing tools on top of your desk, within easy reach.</li>\n	<li>Want to exercise? Set out your workout clothes, shoes, gym bag, and water bottle ahead of time.</li>\n	<li>Want to improve your diet? Chop up a ton of fruits and vegetables on weekends and pack them in containers, so you have easy access to healthy, ready-to-eat options during the week.</li>\n</ul>\n\n<p>These are simple ways to make the good habit the path of least resistance.</p>', 51, '2020-04-18 20:30:28', 27, 0, 0),
(72, 'dummy text', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget</p>\n\n<figure class=\"image\" style=\"float:right\"><img alt=\"image\" height=\"187\" src=\"https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg\" width=\"300\" />\n<figcaption>sunset</figcaption>\n</figure>\n\n<p>condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem.</p>\n\n<p>Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt.</p>\n\n<p>Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>\n\n<p>&nbsp;</p>', 83, '2020-06-11 13:58:58', 23, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_story_tags`
--

CREATE TABLE `tbl_story_tags` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_story_tags`
--

INSERT INTO `tbl_story_tags` (`id`, `story_id`, `tag_id`) VALUES
(1, 61, 39),
(2, 61, 40),
(3, 61, 41),
(4, 62, 40),
(5, 62, 41),
(6, 62, 42),
(7, 63, 43),
(8, 63, 44),
(9, 63, 45),
(10, 64, 43),
(11, 64, 44),
(12, 64, 45),
(13, 65, 43),
(14, 65, 44),
(15, 65, 45),
(16, 66, 46),
(17, 66, 47),
(18, 66, 48),
(19, 67, 49),
(20, 67, 50),
(21, 67, 51),
(22, 68, 46),
(23, 68, 47),
(24, 68, 50),
(25, 69, 46),
(26, 69, 52),
(27, 69, 53),
(28, 70, 49),
(29, 70, 51),
(30, 70, 54),
(31, 71, 55),
(32, 71, 56),
(33, 71, 57),
(34, 72, 58),
(35, 72, 59),
(36, 72, 60);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags`
--

CREATE TABLE `tbl_tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `creationTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tags`
--

INSERT INTO `tbl_tags` (`tag_id`, `tag_name`, `userId`, `creationTime`) VALUES
(39, 'horace-rackham', 1679118554, '2020-04-17 23:35:40'),
(40, 'lorem', 1679118554, '2020-04-17 23:35:40'),
(41, 'ipsum', 1679118554, '2020-04-17 23:35:40'),
(42, 'h. rackham', 1679118554, '2020-04-17 23:39:02'),
(43, 'notag', 1679118554, '2020-04-18 01:44:01'),
(44, 'notag', 1679118554, '2020-04-18 01:44:01'),
(45, 'notag', 1679118554, '2020-04-18 01:44:01'),
(46, 'diet', 1679118554, '2020-04-18 09:15:40'),
(47, 'food', 1679118554, '2020-04-18 09:15:40'),
(48, 'richfood', 1679118554, '2020-04-18 09:15:40'),
(49, 'hotel', 1679118554, '2020-04-18 09:24:23'),
(50, 'traveling', 1679118554, '2020-04-18 09:24:23'),
(51, '4star', 1679118554, '2020-04-18 09:24:23'),
(52, 'healthyfood', 1679118554, '2020-04-18 09:54:35'),
(53, 'helth', 1679118554, '2020-04-18 09:54:35'),
(54, 'affodablehotels', 1712076120, '2020-04-18 10:59:51'),
(55, 'futurehabits', 1679118554, '2020-04-18 14:30:28'),
(56, 'goodhabits', 1679118554, '2020-04-18 14:30:28'),
(57, 'cleanhabits', 1679118554, '2020-04-18 14:30:28'),
(58, 'dummy', 1711004488, '2020-06-11 07:58:58'),
(59, 'text', 1711004488, '2020-06-11 07:58:58'),
(60, 'sunset', 1711004488, '2020-06-11 07:58:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blocked_story`
--
ALTER TABLE `tbl_blocked_story`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blocked_user`
--
ALTER TABLE `tbl_blocked_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_registration`
--
ALTER TABLE `tbl_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_story`
--
ALTER TABLE `tbl_story`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_story_tags`
--
ALTER TABLE `tbl_story_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_blocked_story`
--
ALTER TABLE `tbl_blocked_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_blocked_user`
--
ALTER TABLE `tbl_blocked_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_registration`
--
ALTER TABLE `tbl_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_story`
--
ALTER TABLE `tbl_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_story_tags`
--
ALTER TABLE `tbl_story_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
